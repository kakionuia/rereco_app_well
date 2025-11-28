<?php

use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\KurirDashboardController;
use App\Mail\rerecyle;
use Illuminate\Support\Facades\Mail;

Route::get('/posts/{slug}', function ($slug) {

    $post = Post::find($slug);

    return view('post', ['title' => 'Single post', 'post' => $post]);
});

Route::middleware(['auth', 'verified', App\Http\Middleware\IsKurir::class])->group(function () {
    Route::get('/kurir/dashboard', [KurirDashboardController::class, 'index'])->name('kurir.dashboard');
    Route::post('/kurir/sampah/{id}/points', [\App\Http\Controllers\KurirSampahController::class, 'inputPoints'])->name('kurir.sampah.points');
    Route::get('/kurir/history', [KurirDashboardController::class, 'history'])->name('kurir.history');
});

Route::middleware([App\Http\Middleware\RedirectIfKurir::class])->group(function () {
    Route::get('/', function () {
        // show latest posts and a small product showcase on the home page
        // Post is a simple data provider (not Eloquent). Use a collection sort instead.
        $posts = collect(Post::all())
                    ->sortByDesc(function($p){
                        return !empty($p['created_at']) ? strtotime($p['created_at']) : 0;
                    })
                    ->take(6)
                    ->values();
        $products = \App\Models\Product::where(function($q){ $q->where('is_active', true)->orWhere('stock','>',0); })->orderBy('created_at','desc')->take(12)->get();
        return view('welcome', ['title' => 'Blog', 'posts' => $posts, 'products' => $products]);
    });

    Route::get('/recycle', function () {
        $posts = Post::all();
        $submissions = collect();
        if (Auth::check()) {
            $submissions = \App\Models\SampahSubmission::where('user_id', Auth::id())->orderBy('created_at','desc')->get();
        }
        return view('recycle', ['title' => 'Recycle', 'posts' => $posts, 'submissions' => $submissions]);
    })->name('recycle');

    // ...existing code for other public/user routes...
});

Route::get('/recycle', function () {
    $posts = Post::all();
    $submissions = collect();
    // Note: dropoff flow removed — no automatic cleanup required.

    if (Auth::check()) {
        $submissions = \App\Models\SampahSubmission::where('user_id', Auth::id())->orderBy('created_at','desc')->get();
    }
    return view('recycle', ['title' => 'Recycle', 'posts' => $posts, 'submissions' => $submissions]);
})->name('recycle');

// Public forum routes (threads and viewing)
Route::get('/forum', [\App\Http\Controllers\ForumController::class, 'index'])->name('forum.index');
Route::post('/forum', [\App\Http\Controllers\ForumController::class, 'store'])->name('forum.store');
Route::get('/forum/{id}', [\App\Http\Controllers\ForumController::class, 'show'])->name('forum.show');
// reply to thread (any user)
Route::post('/forum/{id}/reply', [\App\Http\Controllers\ForumController::class, 'reply'])->name('forum.reply');

// Rewards route now redirects to profile points page (rewards items removed)
Route::get('/rewards', function () {
    return redirect()->route('profile.points');
})->name('rewards.index');

// Public shop browsing routes (allow visitors to browse without authentication)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/form', function () {
    return view('form_sampah', ['title' => 'Blog', 'posts' => Post::all()]);
});

Route::get('/about', function () {
    return view('about');
});

// Admin area (protected)
Route::middleware(['auth', 'verified', \App\Http\Middleware\IsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{id}', [AdminController::class, 'userShow'])->name('admin.users.show');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::patch('/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
    Route::get('/activity', [AdminController::class, 'activity'])->name('admin.activity');
    // Point requests (user->admin requests to convert points to e-wallet)
    Route::get('/point-requests', [AdminController::class, 'pointRequests'])->name('admin.point_requests');
    Route::get('/point-requests/{id}', [AdminController::class, 'pointRequestShow'])->name('admin.point_requests.show');
    Route::post('/point-requests/{id}/complete', [AdminController::class, 'pointRequestComplete'])->name('admin.point_requests.complete');
    // orders management
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/{id}', [AdminController::class, 'orderShow'])->name('admin.orders.show');
    Route::delete('/orders/{id}', [AdminController::class, 'orderDestroy'])->name('admin.orders.destroy');
    Route::post('/orders/{id}/confirm', [AdminController::class, 'orderConfirm'])->name('admin.orders.confirm');
    Route::post('/orders/{id}/reject', [AdminController::class, 'orderReject'])->name('admin.orders.reject');
    Route::post('/orders/{id}/ship', [AdminController::class, 'orderShip'])->name('admin.orders.ship');
    Route::post('/orders/{id}/cancel', [AdminController::class, 'orderCancel'])->name('admin.orders.cancel');
    Route::post('/orders/{id}/cancel-request', [AdminController::class, 'processCancelRequest'])->name('admin.orders.cancel_request');
    // sampah submissions
    Route::get('/sampah', [AdminController::class, 'sampah'])->name('admin.sampah');
    Route::get('/sampah/{id}', [AdminController::class, 'sampahShow'])->name('admin.sampah.show');
    Route::delete('/sampah/{id}', [AdminController::class, 'sampahDestroy'])->name('admin.sampah.destroy');
    Route::post('/sampah/{id}/accept', [AdminController::class, 'sampahAccept'])->name('admin.sampah.accept');
    Route::post('/sampah/{id}/reject', [AdminController::class, 'sampahReject'])->name('admin.sampah.reject');
    // user complaints
    Route::get('/complaints', [AdminController::class, 'complaints'])->name('admin.complaints');
    Route::get('/complaints/{id}', [AdminController::class, 'complaintsShow'])->name('admin.complaints.show');
    Route::post('/complaints/{id}/resolve', [AdminController::class, 'complaintResolve'])->name('admin.complaints.resolve');
    // reviews
    Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.reviews');
    Route::delete('/reviews/{id}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    // vouchers management
    Route::get('/vouchers', [\App\Http\Controllers\Admin\VoucherController::class, 'index'])->name('admin.vouchers');
    Route::patch('/vouchers/{id}', [\App\Http\Controllers\Admin\VoucherController::class, 'update'])->name('admin.vouchers.update');
    // kurir sampah management
    Route::get('/kurir', [AdminController::class, 'kurir'])->name('admin.kurir');
    Route::get('/kurir/create', [AdminController::class, 'kurirCreate'])->name('admin.kurir.create');
    Route::post('/kurir', [AdminController::class, 'kurirStore'])->name('admin.kurir.store');
    Route::get('/kurir/{id}', [AdminController::class, 'kurirShow'])->name('admin.kurir.show');
    // forum (admin)
    Route::get('/forum', [\App\Http\Controllers\AdminForumController::class, 'index'])->name('admin.forum');
    Route::get('/forum/{id}', [\App\Http\Controllers\AdminForumController::class, 'show'])->name('admin.forum.show');
    Route::post('/forum/{id}/reply', [\App\Http\Controllers\AdminForumController::class, 'reply'])->name('admin.forum.reply');
});

// Email verification notice (requires auth to show the prompt)
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

use App\Http\Controllers\Auth\GuestVerifyEmailController;
Route::get('/email/verify/{id}/{hash}', GuestVerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');



// Route::get('/test-email', function () {
//     $name = 'Leyla Hanfi';
//     Mail::to('leylahanfi4@gmail.com')->send(new rerecyle($name));
// });


// Password reset routes handled by `routes/auth.php` using the framework controllers.

// Public form for sampah submission (requires auth + GunungPutri region opt-in)
Route::get('/form-sampah', function () {
    if (!Auth::check()) {
        return view('locked', ['reason' => 'Form pengajuan terkunci — harap masuk terlebih dahulu.']);
    }
    $user = Auth::user();
    // only allow users who opted in and selected a village in GunungPutri
    if (! ($user->is_gunungputri ?? false) || empty($user->village)) {
        return view('locked', ['reason' => 'Form pengajuan hanya tersedia untuk warga/penduduk di wilayah GunungPutri. Silakan perbarui profil Anda dan pilih Desa/Kelurahan GunungPutri ketika mendaftar.']);
    }
    return view('form_sampah');
})->name('sampah.form');

Route::post('/form-sampah', [\App\Http\Controllers\SampahController::class, 'store'])->middleware(['auth','verified'])->name('sampah.store');

// allow users to view their own submission details
Route::get('/sampah/{id}', [\App\Http\Controllers\SampahController::class, 'show'])->middleware(['auth','verified'])->name('sampah.show');

Route::get('/dashboard', function () {
    return view('dashboard', ['title' => 'Blog', 'posts' => Post::all()]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Profile points page (authenticated)
    Route::get('/profile/points', function () {
        $user = Auth::user();
        $points = $user->points ?? 0;
        $phone = $user->phone ?? null;
        $requests = \App\Models\Activity::where('user_id', $user->id)
            ->where('action', 'convert_points')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('profile.points', ['points' => $points, 'phone' => $phone, 'requests' => $requests]);
    })->name('profile.points');

    // Convert points to e-wallet balance
    Route::post('/profile/points/convert', [\App\Http\Controllers\ProfileController::class, 'convertPoints'])->name('profile.points.convert');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::post('/voucher/claim/{id}', [\App\Http\Controllers\VoucherController::class, 'claim'])->name('voucher.claim');
    // checkout routes
    Route::get('/shop/{slug}/buy', [ShopController::class, 'buy'])->name('shop.buy');
    Route::post('/shop/{slug}/pay', [ShopController::class, 'pay'])->name('shop.pay');
    Route::get('/shop/checkout/thankyou', [ShopController::class, 'thankyou'])->name('shop.checkout.thankyou');
    
    // user orders
    Route::get('/orders', [ShopController::class, 'orders'])->name('shop.orders');
    Route::get('/orders/{id}', [ShopController::class, 'orderShow'])->name('shop.orders.show');
    // review routes for users (only when authenticated)
    Route::get('/orders/{id}/review/create', [\App\Http\Controllers\ReviewController::class, 'create'])->name('orders.review.create');
    Route::post('/orders/{id}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('orders.review.store');
    Route::get('/reviews/{id}', [\App\Http\Controllers\ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/orders/{id}/receive', [ShopController::class, 'receive'])->name('shop.orders.receive');
    Route::post('/orders/{id}/complain', [ShopController::class, 'submitComplaint'])->name('shop.orders.complain');
    Route::post('/complaints/{id}/satisfaction', [ShopController::class, 'complaintSatisfaction'])->name('shop.complaints.satisfaction');
    Route::post('/orders/{id}/refund-received', [ShopController::class, 'refundReceived'])->name('shop.orders.refund_received');
    Route::post('/orders/{id}/cancel-request', [ShopController::class, 'cancelRequest'])->name('shop.orders.cancel');
});

require __DIR__.'/auth.php';

// Dev-only helper to send a password reset link for testing (Mailtrap).
// This route is registered only when APP_DEBUG=true or the app environment is local.
if (app()->environment('local') || config('app.debug')) {
    Route::match(['get','post'],'/dev/send-reset', function (Request $request) {
        $email = $request->input('email');
        if (! $email) {
            return response()->json(['error' => 'Provide ?email=you@example.test or POST email in body'], 400);
        }

        $request->merge(['email' => $email]);
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        return response()->json(['status' => $status]);
    })->name('dev.send-reset');
}
