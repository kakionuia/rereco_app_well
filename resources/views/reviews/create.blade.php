@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('shop.orders.show', $order->id) }}" class="text-sm text-gray-600 hover:text-gray-800 flex items-center space-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span>Kembali ke Detail Pesanan</span>
            </a>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Product Info Section -->
            <div class="pb-6 border-b border-gray-200 mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Berikan Ulasan Anda</h1>
                <p class="text-gray-600">Bagikan pengalaman Anda untuk membantu pembeli lain membuat keputusan terbaik</p>
            </div>

            <!-- Product Card -->
            <div class="bg-gray-50 rounded-lg p-4 mb-8 flex items-center space-x-4">
                <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-600">Produk</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $product->name ?? 'Produk' }}</p>
                    <p class="text-sm text-gray-500 mt-1">Order #{{ $order->order_number }}</p>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('orders.review.store', $order->id) }}" class="space-y-6" enctype="multipart/form-data">
                @csrf

                <!-- Rating Star Section -->
                <div>
                    <label class="block text-lg font-semibold text-gray-900 mb-4">Berapa rating Anda?</label>
                    <div class="flex items-center space-x-2">
                        <div id="star-rating" class="flex space-x-3" data-rating="0">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" 
                                        class="star-btn focus:outline-none transition-transform hover:scale-110"
                                        data-value="{{ $i }}"
                                        aria-label="Rating {{ $i }} bintang">
                                    <svg class="w-12 h-12 text-gray-300 hover:text-yellow-400 transition-colors"
                                         fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                </button>
                            @endfor
                        </div>
                        <span id="rating-text" class="text-gray-600 text-sm ml-4">Pilih bintang untuk memberi rating</span>
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="0" />
                    @error('rating')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-900 mb-2">Judul Ulasan (opsional)</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           placeholder="Contoh: Produk berkualitas tinggi, pengiriman cepat"
                           class="block w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition"
                           value="{{ old('title') }}" />
                    <p class="text-gray-500 text-xs mt-1">Jelaskan dalam satu kalimat singkat</p>
                </div>

                <!-- Review Body -->
                <div>
                    <label for="body" class="block text-sm font-medium text-gray-900 mb-2">Ulasan Anda</label>
                    <textarea id="body" 
                              name="body" 
                              rows="6"
                              placeholder="Ceritakan pengalaman Anda dengan produk ini. Kualitas? Kesesuaian deskripsi? Kepuasan?"
                              class="block w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition resize-none"
                    >{{ old('body') }}</textarea>
                    <p class="text-gray-500 text-xs mt-1">Minimal 10 karakter untuk ulasan yang bermakna</p>
                </div>

                <!-- Photo Upload -->
                <div>
                    <label for="photos" class="block text-sm font-medium text-gray-900 mb-2">Tambahkan Foto (opsional)</label>
                    <div class="relative">
                        <input 
                            type="file" 
                            id="photos" 
                            name="photos[]" 
                            multiple 
                            accept="image/jpeg,image/png,image/jpg,image/gif"
                            class="hidden"
                        />
                        <label for="photos" class="block cursor-pointer">
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-green-500 hover:bg-green-50 transition">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-600 font-medium">Klik atau seret foto di sini</p>
                                <p class="text-gray-500 text-xs mt-1">PNG, JPG, GIF hingga 5MB per foto (maksimal 5 foto)</p>
                            </div>
                        </label>
                    </div>
                    
                    <!-- Photo Preview Container -->
                    <div id="photo-preview" class="gap-4 mt-4" style="display: none;">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="preview-grid">
                            <!-- Preview items will be inserted here by JavaScript -->
                        </div>
                    </div>
                    
                    <p class="text-gray-500 text-xs mt-2">Foto membantu pembeli lain memahami kualitas produk</p>
                    @error('photos.*')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                        <span class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Kirim Ulasan</span>
                        </span>
                    </button>
                    <a href="{{ route('shop.orders.show', $order->id) }}" 
                       class="px-6 py-3 bg-gray-200 text-gray-900 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Tips Section -->
        <div class="mt-8 bg-green-50 rounded-lg p-6 border border-green-200">
            <h3 class="text-sm font-semibold text-green-800 mb-3 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Tips memberi ulasan yang berguna</span>
            </h3>
            <ul class="text-sm text-green-800 space-y-2">
                <li>✓ Tuliskan pengalaman nyata Anda dengan produk ini</li>
                <li>✓ Jelaskan kelebihan dan kekurangan secara jelas</li>
                <li>✓ Hindari spoiler atau informasi pribadi</li>
                <li>✓ Gunakan bahasa yang sopan dan mudah dipahami</li>
            </ul>
        </div>
    </div>
</div>

<style>
    .star-btn svg {
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    .star-btn.active svg {
        filter: drop-shadow(0 4px 8px rgba(251, 191, 36, 0.3));
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const starRating = document.getElementById('star-rating');
        const stars = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('rating-input');
        const ratingText = document.getElementById('rating-text');
        const photoInput = document.getElementById('photos');
        const photoPreview = document.getElementById('photo-preview');
        const previewGrid = document.getElementById('preview-grid');

        const ratingLabels = {
            0: 'Pilih bintang untuk memberi rating',
            1: 'Sangat Buruk 😞',
            2: 'Kurang Baik 😕',
            3: 'Cukup Baik 😐',
            4: 'Baik 😊',
            5: 'Sangat Baik ⭐'
        };

        // Star rating handling
        stars.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const rating = parseInt(this.dataset.value);
                ratingInput.value = rating;
                
                // Update visual state
                stars.forEach(s => s.classList.remove('active'));
                for (let i = 0; i < rating; i++) {
                    stars[i].classList.add('active');
                }

                // Update stars color
                stars.forEach((s, idx) => {
                    const svg = s.querySelector('svg');
                    if (idx < rating) {
                        svg.classList.remove('text-gray-300');
                        svg.classList.add('text-yellow-400');
                    } else {
                        svg.classList.remove('text-yellow-400');
                        svg.classList.add('text-gray-300');
                    }
                });

                // Update text feedback
                ratingText.textContent = ratingLabels[rating];
            });

            // Hover effect
            btn.addEventListener('mouseenter', function() {
                const rating = parseInt(this.dataset.value);
                stars.forEach((s, idx) => {
                    const svg = s.querySelector('svg');
                    if (idx < rating) {
                        svg.classList.add('text-yellow-300');
                    }
                });
            });
        });

        // Reset hover effect
        starRating.addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingInput.value);
            stars.forEach((s, idx) => {
                const svg = s.querySelector('svg');
                if (idx < currentRating) {
                    svg.classList.remove('text-yellow-300');
                    svg.classList.add('text-yellow-400');
                } else {
                    svg.classList.remove('text-yellow-300');
                    svg.classList.add('text-gray-300');
                }
            });
        });

        // Photo upload handling
        photoInput.addEventListener('change', function(e) {
            const files = Array.from(this.files);
            const maxPhotos = 5;

            if (files.length > maxPhotos) {
                alert(`Maksimal ${maxPhotos} foto yang dapat diunggah`);
                this.value = '';
                previewGrid.innerHTML = '';
                photoPreview.style.display = 'none';
                return;
            }

            previewGrid.innerHTML = '';

            if (files.length > 0) {
                photoPreview.style.display = 'block';

                files.forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'relative group';
                        previewItem.innerHTML = `
                            <div class="relative w-full h-32 bg-gray-100 rounded-lg overflow-hidden">
                                <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all flex items-center justify-center">
                                    <button type="button" class="remove-photo opacity-0 group-hover:opacity-100 transition-opacity bg-red-500 text-white p-2 rounded-full hover:bg-red-600" data-index="${index}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 mt-2 truncate">${file.name}</p>
                        `;
                        previewGrid.appendChild(previewItem);
                    };

                    reader.readAsDataURL(file);
                });

                // Add remove photo handlers
                document.querySelectorAll('.remove-photo').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const newFiles = new DataTransfer();
                        const indexToRemove = parseInt(this.dataset.index);

                        Array.from(photoInput.files).forEach((file, index) => {
                            if (index !== indexToRemove) {
                                newFiles.items.add(file);
                            }
                        });

                        photoInput.files = newFiles.files;
                        photoInput.dispatchEvent(new Event('change'));
                    });
                });
            } else {
                photoPreview.style.display = 'none';
            }
        });

        // Drag and drop
        const dropZone = document.querySelector('label[for="photos"]');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-green-500', 'bg-green-50');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-green-500', 'bg-green-50');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            photoInput.files = files;
            photoInput.dispatchEvent(new Event('change'));
        }
    });
</script>

@endsection
