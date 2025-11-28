@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="lg:flex lg:items-start">
            <!-- Left: Product & Form -->
            <div class="lg:flex-1 p-6">
                <div class="lg:grid lg:grid-cols-2 lg:gap-6">
                    <div class="mb-6 lg:mb-0 flex items-center justify-center">
                        <div class="w-full max-w-xs">
                            <img loading="lazy" src="{{ $product->image ?? '/image/tutup.jpg' }}" alt="{{ $product->name }}" class="w-full h-56 object-contain rounded-md bg-gray-50">
                            <div class="mt-3 text-center">
                                <div class="text-sm text-gray-500">{{ $product->name }}</div>
                                <div class="text-xl font-semibold mt-2 text-green-700">Rp {{ number_format($product->price,0,',','.') }}</div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm text-gray-600">Jumlah</label>
                                <input id="qty" type="number" name="qty" value="{{ old('qty',1) }}" min="1" max="{{ $product->stock }}" class="w-full mt-2 px-3 py-2 rounded-md text-center shadow-sm focus:ring-2 focus:ring-amber-300" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-2xl font-semibold mb-4">Pembayaran</h2>

                        <form id="checkout-form" action="{{ route('shop.pay', $product->slug) }}" method="POST" class="space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" class="mt-1 block w-full rounded-md px-3 py-2 shadow-sm focus:ring-2 focus:ring-green-200" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                                    @php
                                        $catSlug = strtolower($product->category?->slug ?? '');
                                        $catName = strtolower($product->category?->name ?? '');
                                        $isRewardsPayment = ($catSlug === 'rewards' || $catName === 'rewards');
                                    @endphp
                                    <div class="mt-2 flex gap-4 items-center">
                                        @if($isRewardsPayment)
                                            <label class="inline-flex items-center gap-2"><input type="radio" name="payment_method" value="poin" checked class="mr-1"> <span class="text-sm font-semibold">Gunakan Poin</span></label>
                                            <div class="text-sm text-gray-600">Poin Anda: <span class="font-bold text-amber-500">{{ Auth::user()->points ?? 0 }}</span></div>
                                        @else
                                            <label class="inline-flex items-center gap-2"><input type="radio" name="payment_method" value="qris" checked class="mr-1"> <span class="text-sm">QRIS</span></label>
                                            <label class="inline-flex items-center gap-2"><input type="radio" name="payment_method" value="cod" class="mr-1"> <span class="text-sm">COD</span></label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                                <textarea id="address-text" rows="3" placeholder="Jalan, RT/RW, Desa/Kelurahan, Kecamatan, Kode Pos" class="mt-1 block w-full rounded-md px-3 py-2 shadow-sm focus:ring-2 focus:ring-green-200">{{ old('address') }}</textarea>
                                <select id="dropoff-select" class="mt-2 block w-full rounded-md px-3 py-2 shadow-sm" style="display:none;">
                                    <option value="SMKN 1 Gunungputri">SMKN 1 Gunungputri</option>
                                </select>
                                <input type="hidden" name="address" id="form-address" value="{{ old('address') }}">
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Pilihan Pengiriman</label>
                                <div class="mt-2 space-y-2">
                                    @if($isRewardsPayment)
                                        <label class="flex items-center justify-between p-2 rounded-md bg-emerald-50 border border-emerald-100">
                                            <div class="flex items-center gap-2">
                                                <input type="radio" name="shipping_option" value="dropoff" checked class="mr-1"> <div class="text-sm font-semibold">Dropoff (SMKN 1 Gunungputri)</div>
                                            </div>
                                            <div class="text-sm">Rp 0</div>
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">Karena ini produk kategori rewards, pengiriman hanya melalui dropoff.</p>
                                    @else
                                        <label class="flex items-center justify-between p-2 rounded-md hover:bg-gray-50">
                                            <div class="flex items-center gap-2">
                                                <input type="radio" name="shipping_option" value="our" checked class="mr-1"> <div class="text-sm">Jasa kami</div>
                                            </div>
                                            <div class="text-sm">Rp 6.000</div>
                                        </label>
                                        <label class="flex items-center justify-between p-2 rounded-md hover:bg-gray-50">
                                            <div class="flex items-center gap-2">
                                                <input type="radio" name="shipping_option" value="paket" class="mr-1"> <div class="text-sm">Jasa paket</div>
                                            </div>
                                            <div class="text-sm">Rp 10.000</div>
                                        </label>
                                        {{-- <label class="flex items-center justify-between p-2 rounded-md hover:bg-gray-50">
                                            <div class="flex items-center gap-2">
                                                <input type="radio" name="shipping_option" value="dropoff" class="mr-1"> <div class="text-sm">Dropoff (SMKN 1 Gunungputri)</div>
                                            </div>
                                            <div class="text-sm">Rp 0</div>
                                        </label> --}}
                                    @endif
                                </div>
                            </div>
                            </div>

                            @php
                                $catSlug = strtolower($product->category?->slug ?? '');
                                $catName = strtolower($product->category?->name ?? '');
                                $isRewardsCheckout = ($catSlug === 'rewards' || $catName === 'rewards');
                            @endphp

                            @if($isRewardsCheckout)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nomor Rekening (opsional)</label>
                                    <input type="text" name="reward_bank_account" placeholder="Contoh: 1234567890 (Dana/OVO/Bank)" class="mt-1 block w-full rounded-md px-3 py-2 shadow-sm focus:ring-2 focus:ring-amber-200" value="{{ old('reward_bank_account') }}">
                                    <p class="text-xs text-gray-500 mt-1">Opsional — masukkan akun pembayaran untuk mempermudah proses reward.</p>
                                </div>
                            @endif

                            <!-- hidden inputs -->
                            <input type="hidden" name="qty" id="form-qty" value="{{ old('qty',1) }}">
                            <input type="hidden" name="voucher_id" id="form-voucher-id" value="">

                            @php
                                $userPoints = Auth::user()->points ?? 0;
                                $hasEnoughPoints = $userPoints >= $product->price;
                                $buttonDisabled = $isRewardsCheckout && !$hasEnoughPoints;
                            @endphp

                            <div class="flex items-center justify-between">
                                <a href="{{ route('shop.show', $product->slug) }}" class="text-sm text-gray-600 hover:underline">&larr; Kembali</a>
                                @if($buttonDisabled)
                                    <button type="submit" disabled class="px-6 py-2 bg-gray-400 text-gray-700 rounded-md shadow cursor-not-allowed opacity-60">Buat Pesanan</button>
                                @else
                                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700">Buat Pesanan</button>
                                @endif
                            </div>

                            @if($buttonDisabled)
                                <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-md">
                                    <p class="text-sm text-red-700"><strong>Poin tidak cukup!</strong> Anda membutuhkan {{ $product->price }} poin tetapi hanya memiliki {{ $userPoints }} poin.</p>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Order summary (sticky on large screens) -->
            <aside class="lg:w-96 p-6 bg-gray-50 border-l border-transparent lg:sticky lg:top-6">
                <div class="rounded-md bg-white p-4 shadow-sm">
                    <h3 class="text-lg font-semibold mb-3">Ringkasan Pesanan</h3>
                    <div class="text-sm text-gray-700 space-y-3">
                        <div class="flex justify-between"><span>Subtotal barang</span><span id="summary-item-total">Rp {{ number_format($product->price,0,',','.') }}</span></div>
                        <div class="flex justify-between"><span>Biaya layanan</span><span id="summary-service-fee">Rp 2.000</span></div>
                        <div class="flex justify-between"><span>Ongkos kirim</span><span id="summary-shipping">Rp 6.000</span></div>
                        <div id="applied-discount-row" class="flex justify-between text-sm text-red-600" style="display:none;">
                            <span>Voucher</span>
                            <span id="applied-discount-badge" class="font-medium">- Rp 0</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between items-center">
                            <div class="text-sm font-medium">Total</div>
                            <div class="text-xl font-bold" id="grand-total">Rp {{ number_format($product->price + 2000 + 6000,0,',','.') }}</div>
                        </div>
                        <div class="mt-3 text-center text-sm text-gray-600">Total yang harus dibayar</div>
                        <div class="text-2xl font-extrabold text-green-700 text-center" id="checkout-total">Rp {{ number_format($product->price + 2000 + 6000,0,',','.') }}</div>
                    </div>
                    @if(isset($claimedVouchers) && count($claimedVouchers) > 0)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Gunakan Voucher</label>
                            <select id="voucher-select" class="mt-2 block w-full rounded-md px-3 py-2 border" >
                                <option value="">-- Pilih voucher (opsional) --</option>
                                @foreach($claimedVouchers as $cv)
                                    <option value="{{ $cv->id }}" data-type="{{ $cv->voucher->discount_type }}" data-value="{{ $cv->voucher->discount_value }}">{{ $cv->voucher->code }} — @if($cv->voucher->discount_type==='percent') {{ $cv->voucher->discount_value }}% @else Rp {{ number_format($cv->voucher->discount_value,0,',','.') }} @endif</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
    (function(){
        const price = {{ (int) $product->price }};
        const isRewards = {{ $isRewardsCheckout ? 'true' : 'false' }};
        const serviceFee = isRewards ? 0 : 2000;
        const shippingCosts = { our:6000, paket:10000, dropoff:0 };

        const qtyInput = document.getElementById('qty');
        const formQty = document.getElementById('form-qty');
        const summaryItemEl = document.getElementById('summary-item-total');
        const summaryServiceEl = document.getElementById('summary-service-fee');
        const summaryShippingEl = document.getElementById('summary-shipping');
        const grandTotalEl = document.getElementById('grand-total');
        const checkoutTotalEl = document.getElementById('checkout-total');

        const addressTextEl = document.getElementById('address-text');
        const dropoffSelectEl = document.getElementById('dropoff-select');
        const formAddressEl = document.getElementById('form-address');

        function formatRp(n){ return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }

        function updateTotals(){
            const qty = Math.max(1, parseInt(qtyInput.value || '1'));
            formQty.value = qty;
            const itemTotal = price * qty;
            const shippingOption = document.querySelector('input[name="shipping_option"]:checked')?.value || 'our';
            const shipping = shippingCosts[shippingOption] || 0;
            let grand = itemTotal + serviceFee + shipping;

            const voucherSelect = document.getElementById('voucher-select');
            let appliedDiscount = 0;
            if (voucherSelect && voucherSelect.value) {
                const opt = voucherSelect.options[voucherSelect.selectedIndex];
                const dtype = opt.getAttribute('data-type');
                const dval = parseInt(opt.getAttribute('data-value') || '0');
                if (dtype === 'percent') {
                    appliedDiscount = Math.round((dval/100) * itemTotal);
                } else {
                    appliedDiscount = dval;
                }
                appliedDiscount = Math.min(appliedDiscount, itemTotal);
                grand = Math.max(0, grand - appliedDiscount);
            }

            summaryItemEl.textContent = formatRp(itemTotal);
            summaryServiceEl.textContent = formatRp(serviceFee);
            summaryShippingEl.textContent = formatRp(shipping);
            grandTotalEl.textContent = formatRp(grand);
            checkoutTotalEl.textContent = formatRp(grand);

            const discountBadge = document.getElementById('applied-discount-badge');
            const discountRow = document.getElementById('applied-discount-row');
            if (discountBadge && discountRow) {
                if (appliedDiscount > 0) {
                    discountBadge.textContent = '- ' + formatRp(appliedDiscount);
                    discountRow.style.display = 'flex';
                } else {
                    discountRow.style.display = 'none';
                }
            }

            if (shippingOption === 'dropoff') {
                formAddressEl.value = dropoffSelectEl.value;
            } else {
                formAddressEl.value = addressTextEl.value || '';
            }
        }

        qtyInput.addEventListener('change', updateTotals);

        const voucherSelectEl = document.getElementById('voucher-select');
        const formVoucherId = document.getElementById('form-voucher-id');
        if (voucherSelectEl) {
            voucherSelectEl.addEventListener('change', function(){
                formVoucherId.value = voucherSelectEl.value || '';
                updateTotals();
            });
        }

        document.querySelectorAll('input[name="shipping_option"]').forEach(el => el.addEventListener('change', function(){
            const v = document.querySelector('input[name="shipping_option"]:checked')?.value || 'our';
            if (v === 'dropoff') {
                dropoffSelectEl.style.display = 'block';
                addressTextEl.style.display = 'none';
                addressTextEl.removeAttribute('required');
                formAddressEl.value = dropoffSelectEl.value;
            } else {
                dropoffSelectEl.style.display = 'none';
                addressTextEl.style.display = 'block';
                addressTextEl.setAttribute('required','required');
                formAddressEl.value = addressTextEl.value || '';
            }
            updateTotals();
        }));

        addressTextEl.addEventListener('input', function(){
            const v = document.querySelector('input[name="shipping_option"]:checked')?.value || 'our';
            if (v !== 'dropoff') formAddressEl.value = addressTextEl.value || '';
        });
        dropoffSelectEl.addEventListener('change', function(){ formAddressEl.value = dropoffSelectEl.value; });

        (function initAddressUI(){
            const v = document.querySelector('input[name="shipping_option"]:checked')?.value || 'our';
            if (v === 'dropoff') {
                dropoffSelectEl.style.display = 'block';
                addressTextEl.style.display = 'none';
                addressTextEl.removeAttribute('required');
                formAddressEl.value = dropoffSelectEl.value;
            } else {
                dropoffSelectEl.style.display = 'none';
                addressTextEl.style.display = 'block';
                addressTextEl.setAttribute('required','required');
                formAddressEl.value = addressTextEl.value || '';
            }
        })();
        updateTotals();

        document.getElementById('checkout-form').addEventListener('submit', function(){
            const v = document.querySelector('input[name="shipping_option"]:checked')?.value || 'our';
            if (v === 'dropoff') formAddressEl.value = dropoffSelectEl.value;
            else formAddressEl.value = addressTextEl.value || '';
        });
    })();
</script>
@endsection
