<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\Complaint;
// Storage facade was imported earlier but is not used in this controller.
// Removed to avoid editor "unused import" warnings for stricter linters.

class AdminController extends Controller
{
    // List kurir sampah
    public function kurir()
    {
        $kurirs = User::where('is_kurir', true)->orderBy('created_at', 'desc')->get();
        return view('admin.kurir', compact('kurirs'));
    }

    // Form tambah kurir
    public function kurirCreate()
    {
        return view('admin.kurir_create');
    }

    // Simpan kurir baru
    public function kurirStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'wilayah' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->adress = $data['wilayah'];
        $user->is_kurir = true;
        $user->password = bcrypt($data['password']);
        $user->email_verified_at = now(); // langsung verifikasi
        $user->save();
        return redirect()->route('admin.kurir')->with('success', 'Akun kurir berhasil ditambahkan.');
    }

    /**
     * Show kurir detail: account info, total kg handled, total points awarded, and history.
     */
    public function kurirShow($id)
    {
        $kurir = User::findOrFail($id);

        // Use the same logic as KurirDashboardController::history — show completed submissions
        // in the kurir's wilayah (prefer `village`, fallback to `adress`). This mirrors what
        // a kurir sees on their own history page.
        $wilayah = $kurir->village ?? $kurir->adress;

        $submissions = \App\Models\SampahSubmission::where('status', 'completed')
            ->whereHas('user', function($q) use ($wilayah) {
                $q->where('village', $wilayah)->orWhere('adress', $wilayah);
            })
            ->with('user')
            ->orderByDesc('tanggal_pickup')
            ->orderByDesc('waktu_pickup')
            ->get();

        // Totals for history: total weight and total points awarded for completed tasks
        $totalKg = $submissions->sum(function($s){ return (float) ($s->berat_aktual ?? 0); });
        $totalPoints = $submissions->sum(function($s){ return (int) ($s->points_awarded ?? 0); });

        return view('admin.kurir_show', compact('kurir', 'submissions', 'totalKg', 'totalPoints'));
    }
    public function index()
    {
        // Calculate dynamic stats for dashboard
        // show total accounts as the main top-left stat
        $articles = User::count();
        // Replace visitors placeholder with complaints for the current month
        $visitors = 0; // kept as legacy key name but will be replaced in view usage
        $complaintsThisMonth = Complaint::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        // Products sold: sum of qty for delivered orders
        $productsSoldQty = Order::where('status', 'delivered')->sum('qty');
        // Count of delivered orders
        $deliveredOrdersCount = Order::where('status', 'delivered')->count();

        // Pending counts
        $pendingOrders = Order::where('status', 'pending')->count();
        $pendingSampah = \App\Models\SampahSubmission::where('status', 'pending')->count();

        // Count pending point conversion requests (Activity.action = convert_points)
        $pendingPointRequests = Activity::where('action', 'convert_points')
            ->where(function($q){
                $q->whereNull('data->status')
                  ->orWhereNotIn('data->status', ['completed','confirmed']);
            })->count();

        $reports = $pendingOrders + $pendingSampah + $pendingPointRequests;

        // Aggregate sampah statistics: total kg (completed) and breakdown by jenis
        $sampahQuery = \App\Models\SampahSubmission::where('status', 'completed');
        $totalKgAll = (float) $sampahQuery->sum('berat_aktual');

        $byJenis = \Illuminate\Support\Facades\DB::table('sampah_submissions')
            ->select('jenis', \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(berat_aktual),0) as total_kg'))
            ->where('status', 'completed')
            ->groupBy('jenis')
            ->get()
            ->mapWithKeys(function($row){ return [($row->jenis ?? 'Lainnya') => (float) $row->total_kg]; })
            ->toArray();

        // Use the total product count from the products page as "produk dihasilkan"
        $productsFromWaste = \App\Models\Product::count();

        // Total revenue from delivered products (sum of Order.total where status = delivered)
        $deliveredRevenue = (float) Order::where('status', 'delivered')->sum('total');

        $stats = [
            'articles' => $articles,
            'visitors' => $visitors,
            'complaints_this_month' => $complaintsThisMonth,
            'products_sold' => $productsSoldQty,
            'delivered_orders' => $deliveredOrdersCount,
            'reports' => $reports,
            'pending_orders' => $pendingOrders,
            'pending_sampah' => $pendingSampah,
            'pending_point_requests' => $pendingPointRequests,
            'total_kg_all' => $totalKgAll,
            'sampah_by_jenis' => $byJenis,
            'products_from_waste' => $productsFromWaste,
            'delivered_revenue' => $deliveredRevenue,
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::orderBy('created_at','desc')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function userShow($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user_show', compact('user'));
    }

    public function destroyUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // prevent deleting yourself
    if (Auth::id() === $user->id) {
            return redirect()->back()->with('error','Tidak dapat menghapus akun yang sedang masuk.');
        }
        $user->delete();
        // log activity
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'delete_user',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'data' => ['email' => $user->email, 'name' => $user->name],
            'ip' => $request->ip(),
        ]);
        return redirect()->route('admin.users')->with('success','Pengguna dihapus.');
    }

    public function products()
    {
        $products = Product::with('category')->orderBy('created_at','desc')->paginate(24);
        return view('admin.products', compact('products'));
    }

    public function createProduct()
    {
        // ensure the site default shop categories exist and then load them
        $this->ensureDefaultShopCategories();
        $categories = Category::orderBy('name')->get();
        return view('admin.products_create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = '/storage/' . $path;
        }

        // create slug
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']) . '-' . substr(uniqid(), -4);
        $data['is_active'] = $request->has('is_active') ? true : true;

        $product = Product::create($data);

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'create_product',
            'subject_type' => Product::class,
            'subject_id' => $product->id,
            'data' => ['name' => $product->name, 'price' => $product->price],
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.products')->with('success', 'Produk baru berhasil ditambahkan.');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        // ensure the site default shop categories exist and then load them
        $this->ensureDefaultShopCategories();
        $categories = Category::orderBy('name')->get();
        return view('admin.products_edit', compact('product','categories'));
    }

    /**
     * Ensure the core shop categories exist in the database.
     * This will create categories with slugs 'organik', 'elektronik', 'anorganik' if missing.
     */
    protected function ensureDefaultShopCategories()
    {
        $defaults = [
            'organik' => 'Organik',
            'elektronik' => 'Elektronik',
            'anorganik' => 'Anorganik',
        ];

        foreach ($defaults as $slug => $name) {
            Category::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $product->update($data);
        // If admin updates stock to a positive value, ensure product becomes active again
        if (isset($data['stock'])) {
            $product->is_active = ((int)$data['stock'] > 0) ? true : $product->is_active;
            // if stock is zero, keep previous is_active value (we won't auto-disable here)
            $product->save();
        }
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'update_product',
            'subject_type' => Product::class,
            'subject_id' => $product->id,
            'data' => ['name' => $product->name, 'changes' => $data],
            'ip' => $request->ip(),
        ]);
        return redirect()->route('admin.products')->with('success','Produk diperbarui.');
    }

    public function destroyProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'delete_product',
            'subject_type' => Product::class,
            'subject_id' => $product->id,
            'data' => ['name' => $product->name],
            'ip' => $request->ip(),
        ]);
        return redirect()->route('admin.products')->with('success','Produk dihapus.');
    }

    public function activity()
    {
        // Limit activity log to the latest 100 entries for performance and UX.
        $perPage = 30;
        $page = (int) request()->query('page', 1);

        $allRecent = Activity::with('user')->orderBy('created_at','desc')->limit(100)->get();

        // Use LengthAwarePaginator so Blade's links() works as expected.
        $total = $allRecent->count();
        $itemsForCurrentPage = $allRecent->slice(($page - 1) * $perPage, $perPage)->values();

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsForCurrentPage,
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $activities = $paginator;
        return view('admin.activity', compact('activities'));
    }

    /**
     * List point conversion requests made by users.
     */
    public function pointRequests()
    {
        $requests = Activity::with('user')
            ->where('action', 'convert_points')
            ->where(function($q){
                $q->whereNull('data->status')
                  ->orWhereNotIn('data->status', ['completed','confirmed']);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('admin.point_requests', compact('requests'));
    }

    /**
     * Show details for a single point request activity.
     */
    public function pointRequestShow($id)
    {
        $req = Activity::with('user')->findOrFail($id);
        if ($req->action !== 'convert_points') {
            abort(404);
        }
        return view('admin.point_requests_show', compact('req'));
    }

    /**
     * Mark a point request as completed by admin.
     */
    public function pointRequestComplete(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        if ($activity->action !== 'convert_points') {
            return redirect()->back()->with('error', 'Aktivitas bukan permintaan poin.');
        }

        $data = $activity->data ?? [];
        $data['status'] = 'completed';
        $data['admin_id'] = Auth::id();
        $data['completed_at'] = now()->toDateTimeString();
        $activity->data = $data;
        $activity->save();

        // Log admin action
        try {
            Activity::create([
                'user_id' => Auth::id(),
                'action' => 'complete_point_request',
                'subject_type' => Activity::class,
                'subject_id' => $activity->id,
                'data' => ['for_user' => $activity->user_id, 'amount_idr' => $data['amount_idr'] ?? null],
                'ip' => $request->ip()
            ]);
        } catch (\Throwable $e) {
            // ignore
        }

        return redirect()->route('admin.point_requests.show', $activity->id)->with('success', 'Permintaan poin ditandai selesai.');
    }

    // Sampah submissions management
    public function sampah()
    {
        // Show all submissions to admin (include accepted so admin and kurir see entries at same time)
        $submissions = \App\Models\SampahSubmission::orderBy('created_at','desc')->paginate(20);
        return view('admin.sampah', compact('submissions'));
    }

    public function sampahShow($id)
    {
        $submission = \App\Models\SampahSubmission::findOrFail($id);
        return view('admin.sampah_show', compact('submission'));
    }

    public function sampahDestroy(Request $request, $id)
    {
        $submission = \App\Models\SampahSubmission::findOrFail($id);
        // delete foto file if exists
        if ($submission->foto_path) {
            // foto_path stored as "/storage/xyz" — remove leading /storage/ to delete from public disk
            $relative = ltrim($submission->foto_path, '/');
            if (str_starts_with($relative, 'storage/')) {
                $relative = substr($relative, strlen('storage/'));
            }
            try {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($relative);
            } catch (\Throwable $e) {
                // ignore
            }
        }
        $submission->delete();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'delete_sampah_submission',
            'subject_type' => \App\Models\SampahSubmission::class,
            'subject_id' => $id,
            'data' => ['id' => $id],
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.sampah')->with('success', 'Pengajuan dihapus.');
    }

    // Accept a submission and award points to the user
    public function sampahAccept(Request $request, $id)
    {
        $submission = \App\Models\SampahSubmission::findOrFail($id);
        $points = (int) $request->input('points', 0);
        $message = (string) $request->input('message', '');
        $submission->status = 'accepted';
        $submission->points_awarded = $points;
        if ($message !== '') { $submission->admin_message = $message; }
        $submission->save();

        if ($submission->user_id) {
            $user = \App\Models\User::find($submission->user_id);
            if ($user) {
                $user->points = ($user->points ?? 0) + $points;
                $user->save();
            }
        }

        $activityData = ['points' => $points];
        if ($submission->user) {
            $activityData['submitted_by'] = ['id' => $submission->user->id, 'name' => $submission->user->name, 'email' => $submission->user->email];
        }
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'accept_sampah_submission',
            'subject_type' => \App\Models\SampahSubmission::class,
            'subject_id' => $id,
            'data' => $activityData,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.sampah.show', $id)->with('success', 'Pengajuan diterima dan poin diberikan.');
    }

    // Reject a submission
    public function sampahReject(Request $request, $id)
    {
        $submission = \App\Models\SampahSubmission::findOrFail($id);
        $submission->status = 'rejected';
        $reason = (string) $request->input('message', $request->input('reason'));
        $submission->reject_reason = $reason;
        if ($reason !== '') { $submission->admin_message = $reason; }
        $submission->save();

        $activityData = ['reason' => $request->input('reason')];
        if ($submission->user) {
            $activityData['submitted_by'] = ['id' => $submission->user->id, 'name' => $submission->user->name, 'email' => $submission->user->email];
        }
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'reject_sampah_submission',
            'subject_type' => \App\Models\SampahSubmission::class,
            'subject_id' => $id,
            'data' => $activityData,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.sampah.show', $id)->with('success', 'Pengajuan ditolak.');
    }

    // Orders management
    public function orders()
    {
        $q = trim((string) request()->query('q', ''));

        $query = Order::with(['product','user'])->orderBy('created_at','desc');

        if ($q !== '') {
            $query->where(function($w) use ($q) {
                // numeric id exact match
                if (is_numeric($q)) {
                    $w->orWhere('id', (int) $q);
                }
                $w->orWhere('order_number', 'like', "%{$q}%")
                  ->orWhere('product_name', 'like', "%{$q}%")
                  ->orWhere('name', 'like', "%{$q}%");

                // search buyer email or name via relation
                $w->orWhereHas('user', function($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
                });
            });
        }

        $orders = $query->where('status', '!=', 'delivered')->paginate(30);
        // preserve q in pagination links
        $orders->appends(request()->only('q'));

        return view('admin.orders', compact('orders','q'));
    }

    public function orderShow($id)
    {
        $order = Order::with(['product','user'])->findOrFail($id);
        return view('admin.order_show', compact('order'));
    }

    public function orderConfirm(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        DB::transaction(function() use ($order, $request) {
            // mark order confirmed
            $order->status = 'confirmed';
            $order->save();

            // decrement product stock if possible
            if ($order->product_id) {
                $product = Product::find($order->product_id);
                if ($product) {
                    $newStock = max(0, ($product->stock ?? 0) - ($order->qty ?? 0));
                    $product->stock = $newStock;
                    // if stock exhausted, mark product as not active
                    if ($newStock <= 0) {
                        $product->is_active = false;
                    }
                    $product->save();
                }
            }

            Activity::create([
                'user_id' => Auth::id(),
                'action' => 'confirm_order',
                'subject_type' => Order::class,
                'subject_id' => $order->id,
                'data' => ['order_number' => $order->order_number],
                'ip' => $request->ip(),
            ]);
        });

        return redirect()->route('admin.orders.show', $id)->with('success','Order berhasil dikonfirmasi.');
    }

    public function orderReject(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'rejected';
        $order->metadata = array_merge($order->metadata ?? [], ['reject_reason' => $request->input('reason')]);
        $order->save();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'reject_order',
            'subject_type' => Order::class,
            'subject_id' => $order->id,
            'data' => ['order_number' => $order->order_number, 'reason' => $request->input('reason')],
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.orders.show', $id)->with('success','Order ditolak.');
    }

    // Complaints management
    public function complaints()
    {
        $q = trim((string) request()->query('q', ''));

        $query = Complaint::with(['order','user'])->orderBy('created_at','desc');
        if ($q !== '') {
            $query->where(function($w) use ($q) {
                if (is_numeric($q)) {
                    $w->orWhere('id', (int) $q);
                }
                $w->orWhere('title', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%");

                $w->orWhereHas('order', function($o) use ($q) {
                    $o->where('order_number', 'like', "%{$q}%");
                });

                $w->orWhereHas('user', function($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
                });
            });
        }

            $complaints = $query->where('status', '!=', 'confirmed')->paginate(30);
        $complaints->appends(request()->only('q'));

        return view('admin.complaints', compact('complaints','q'));
    }

    public function complaintsShow($id)
    {
        $complaint = Complaint::with(['order','user'])->findOrFail($id);
        return view('admin.complaints_show', compact('complaint'));
    }

    public function complaintResolve(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $action = $request->input('action', 'confirm'); // confirm or reject

        // Admin must provide a note when taking action
        $request->validate([
            'note' => 'required|string|max:2000',
        ]);

        if ($action === 'reject') {
            $complaint->status = 'rejected';
            $complaint->metadata = array_merge($complaint->metadata ?? [], ['admin_note' => $request->input('note')]);
        } else {
            // admin confirmed/handled the complaint — mark as confirmed and wait user's satisfaction
            $complaint->status = 'confirmed';
            $complaint->metadata = array_merge($complaint->metadata ?? [], ['admin_note' => $request->input('note'), 'confirmed_at' => now()->toDateTimeString()]);
        }
        $complaint->save();

        // send notification email to complainant if available (only when rejected)
        if ($action === 'reject') {
            try {
                if ($complaint->user && !empty($complaint->user->email)) {
                    \Illuminate\Support\Facades\Mail::to($complaint->user->email)->send(new \App\Mail\ComplaintRejected($complaint));
                }
            } catch (\Throwable $e) {
                // ignore mail errors for now
            }
        }

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'resolve_complaint',
            'subject_type' => Complaint::class,
            'subject_id' => $complaint->id,
            'data' => ['status' => $complaint->status],
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.complaints.show', $id)->with('success', 'Keluhan telah diperbarui.');
    }

    /**
     * Mark order as on the way (dikirim)
     */
    public function orderShip(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'on_the_way';
        $order->save();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'ship_order',
            'subject_type' => Order::class,
            'subject_id' => $order->id,
            'data' => ['order_number' => $order->order_number],
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.orders.show', $id)->with('success','Order dikirim.');
    }

    /**
     * Cancel an order from admin panel
     */
    public function orderCancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'canceled';
        $order->save();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'cancel_order',
            'subject_type' => Order::class,
            'subject_id' => $order->id,
            'data' => ['order_number' => $order->order_number],
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.orders.show', $id)->with('success','Order dibatalkan.');
    }

    /**
     * Permanently delete an order (admin only). Used for canceled orders.
     */
    public function orderDestroy(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Only allow deleting canceled orders to avoid accidental removal
        if ($order->status !== 'canceled') {
            return redirect()->back()->with('error', 'Hanya pesanan dengan status "canceled" yang dapat dihapus.');
        }

        $order->delete();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'delete_order',
            'subject_type' => Order::class,
            'subject_id' => $id,
            'data' => ['order_number' => $order->order_number],
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.orders')->with('success', 'Order dibersihkan dari sistem.');
    }

    /**
     * Process a user's cancellation request (admin approves or rejects).
     */
    public function processCancelRequest(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $data = $request->validate([
            'action' => 'required|in:accept,reject',
            'note' => 'nullable|string|max:2000',
        ]);

        $meta = $order->metadata ?? [];
        $meta = is_array($meta) ? $meta : (array) $meta;

        if (empty($meta['cancel_request']) || !is_array($meta['cancel_request'])) {
            return redirect()->route('admin.orders.show', $id)->with('error', 'Tidak ada permintaan pembatalan yang ditemukan.');
        }

        $adminNote = $data['note'] ?? null;

        if ($data['action'] === 'accept') {
            // Admin accepts cancellation: mark order canceled and update metadata
            $order->status = 'canceled';
            $meta['cancel_request']['status'] = 'accepted';
            $meta['cancel_request']['admin_note'] = $adminNote;
            $meta['cancel_request']['processed_at'] = now()->toDateTimeString();
            $meta['cancel_request']['processed_by'] = Auth::id();
            $order->metadata = $meta;
            $order->save();

            Activity::create([
                'user_id' => Auth::id(),
                'action' => 'admin_accept_cancel_request',
                'subject_type' => Order::class,
                'subject_id' => $order->id,
                'data' => ['order_number' => $order->order_number, 'note' => $adminNote],
                'ip' => $request->ip(),
            ]);

            return redirect()->route('admin.orders.show', $id)->with('success', 'Permintaan pembatalan diterima dan order dibatalkan.');
        }

        // reject the cancellation request
        $meta['cancel_request']['status'] = 'rejected';
        $meta['cancel_request']['admin_note'] = $adminNote;
        $meta['cancel_request']['processed_at'] = now()->toDateTimeString();
        $meta['cancel_request']['processed_by'] = Auth::id();
        $order->metadata = $meta;
        $order->save();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'admin_reject_cancel_request',
            'subject_type' => Order::class,
            'subject_id' => $order->id,
            'data' => ['order_number' => $order->order_number, 'note' => $adminNote],
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.orders.show', $id)->with('success', 'Permintaan pembatalan ditolak.');
    }

}
