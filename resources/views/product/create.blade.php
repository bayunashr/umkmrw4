@extends('layouts.umkm')

@section('title', 'Tambah Produk & Layanan - Banjarsugihan UMKM Digital Map')

@section('content')
    <div class="card mb-6">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between mb-lg-4">
            <div class="flex-grow-0 me-md-3">
                <a href="{{ route('umkm.product') }}" class="btn btn-outline-secondary btn-sm">
                    <span class="ri-arrow-go-back-fill me-1"></span> Kembali
                </a>
            </div>
            <div class="flex-grow-1 text-center text-md-start mt-2 mt-md-0">
                <h5 class="mb-0">Tambah Produk & Layanan</h5>
                <small class="text-muted">Tambah produk dan layanan UMKM Anda</small>
            </div>
        </div>

        <form class="card-body" method="POST" action="{{ route('umkm.product.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-6">
                {{-- Nama Produk --}}
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-shopping-bag-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input
                                name="name"
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Nama Produk"
                                value="{{ old('name') }}"
                                required
                            />
                            <label>Nama Produk <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    @error('name')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">Rp</span>
                        <div class="form-floating form-floating-outline">
                            <input
                                name="price"
                                type="number"
                                step="0.01"
                                min="0"
                                class="form-control @error('price') is-invalid @enderror"
                                placeholder="Harga Produk"
                                value="{{ old('price') }}"
                            />
                            <label>Harga Produk (opsional)</label>
                        </div>
                    </div>
                    @error('price')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- Deskripsi Produk --}}
                <div class="col-12">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text align-items-start pt-3"><i class="ri-align-left"></i></span>
                        <div class="form-floating form-floating-outline">
                            <textarea
                                name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Deskripsi Produk"
                                style="height: 150px"
                                required
                            >{{ old('description') }}</textarea>
                            <label>Deskripsi Produk <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    @error('description')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- Upload Gambar Produk --}}
                <div class="col-12">
                    <label class="form-label mb-3">
                        <i class="ri-image-line me-2"></i>
                        Gambar Produk
                        <span class="text-muted">(opsional)</span>
                    </label>

                    <div class="upload-area">
                        <input
                            type="file"
                            name="image"
                            id="image-upload"
                            class="d-none @error('image') is-invalid @enderror"
                            accept="image/jpeg,image/jpg,image/png"
                            onchange="handleImageUpload(this)"
                        >

                        <div id="upload-zone" class="upload-zone" onclick="document.getElementById('image-upload').click()">
                            <div class="upload-content text-center">
                                <div class="upload-icon mb-3">
                                    <i class="ri-upload-cloud-2-line"></i>
                                </div>
                                <h6 class="upload-title mb-2">Klik untuk upload gambar</h6>
                                <p class="upload-subtitle text-muted mb-0">
                                    Format: JPG, PNG, JPEG • Maksimal: 5MB
                                </p>
                            </div>
                        </div>

                        <div id="image-preview" class="image-preview-container" style="display: none;">
                            <div class="preview-wrapper">
                                <img id="preview-image" class="preview-img" src="" alt="Preview">
                                <div class="preview-overlay">
                                    <button type="button" class="btn-remove" onclick="removeImage()" title="Hapus gambar">
                                        <i class="ri-close-line"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="image-info">
                                <p class="image-name mb-1" id="image-name"></p>
                                <small class="image-size text-muted" id="image-size"></small>
                            </div>
                        </div>
                    </div>

                    @error('image')
                    <div class="form-text text-danger mt-2">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror

                    <div class="form-text text-muted mt-2">
                        <i class="ri-information-line me-1"></i>
                        Gambar yang menarik akan membantu pembeli tertarik dengan produk Anda
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="pt-6">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <a href="{{ route('umkm.product') }}" class="btn btn-outline-secondary w-100">
                            <i class="ri-arrow-go-back-line me-1"></i> Batal
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ri-save-line me-1"></i> Simpan Produk
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .upload-area {
            width: 100%;
        }

        .upload-zone {
            border: 2px dashed #d0d5dd;
            border-radius: 16px;
            background: #f9fafb;
            padding: 32px 24px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .upload-zone:hover {
            border-color: #696cff;
            background: #f8f9ff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(105, 108, 255, 0.1);
        }

        .upload-content {
            pointer-events: none;
        }

        .upload-icon {
            color: #696cff;
            font-size: 40px;
            line-height: 1;
        }

        .upload-zone:hover .upload-icon {
            color: #5a5fef;
        }

        .upload-title {
            color: #344054;
            font-weight: 600;
            font-size: 16px;
            margin: 0;
        }

        .upload-subtitle {
            color: #667085;
            font-size: 14px;
            margin: 0;
        }

        .image-preview-container {
            border: 2px solid #10b981;
            border-radius: 16px;
            background: #f0fdf4;
            padding: 16px;
        }

        .preview-wrapper {
            position: relative;
            width: 100%;
            height: 200px;
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
            margin-bottom: 12px;
        }

        .preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-overlay {
            position: absolute;
            top: 8px;
            right: 8px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .preview-wrapper:hover .preview-overlay {
            opacity: 1;
        }

        .btn-remove {
            background: rgba(239, 68, 68, 0.9);
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-remove:hover {
            background: #dc2626;
            transform: scale(1.1);
        }

        .image-info {
            text-align: center;
        }

        .image-name {
            color: #374151;
            font-weight: 500;
            font-size: 14px;
            margin: 0;
            word-break: break-all;
        }

        .image-size {
            color: #6b7280;
            font-size: 12px;
        }

        /* Error state */
        .upload-zone.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .upload-zone.error .upload-icon {
            color: #ef4444;
        }

        .upload-zone.error .upload-title {
            color: #dc2626;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .upload-zone {
                padding: 24px 16px;
            }

            .upload-icon {
                font-size: 32px;
            }

            .upload-title {
                font-size: 14px;
            }

            .upload-subtitle {
                font-size: 12px;
            }

            .preview-wrapper {
                height: 160px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function handleImageUpload(input) {
            const file = input.files[0];
            const uploadZone = document.getElementById('upload-zone');
            const previewContainer = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-image');
            const imageName = document.getElementById('image-name');
            const imageSize = document.getElementById('image-size');

            // Reset error state
            uploadZone.classList.remove('error');

            if (file) {
                // Validasi file
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                const maxSize = 5 * 1024 * 1024; // 5MB

                if (!allowedTypes.includes(file.type)) {
                    showError('Format file tidak didukung. Gunakan JPG, PNG, atau JPEG.');
                    input.value = '';
                    return;
                }

                if (file.size > maxSize) {
                    showError('Ukuran file terlalu besar. Maksimal 5MB.');
                    input.value = '';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imageName.textContent = file.name;
                    imageSize.textContent = formatFileSize(file.size);

                    uploadZone.style.display = 'none';
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            const input = document.getElementById('image-upload');
            const uploadZone = document.getElementById('upload-zone');
            const previewContainer = document.getElementById('image-preview');

            input.value = '';
            uploadZone.style.display = 'block';
            previewContainer.style.display = 'none';
            uploadZone.classList.remove('error');
        }

        function showError(message) {
            const uploadZone = document.getElementById('upload-zone');
            uploadZone.classList.add('error');

            // Create or update error message
            let errorMsg = document.querySelector('.upload-error-msg');
            if (!errorMsg) {
                errorMsg = document.createElement('div');
                errorMsg.className = 'upload-error-msg text-danger mt-2';
                uploadZone.parentNode.appendChild(errorMsg);
            }
            errorMsg.innerHTML = `<i class="ri-error-warning-line me-1"></i>${message}`;

            // Remove error message after 5 seconds
            setTimeout(() => {
                if (errorMsg) {
                    errorMsg.remove();
                }
                uploadZone.classList.remove('error');
            }, 5000);
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Handle form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const uploadZone = document.getElementById('upload-zone');
            const submitBtn = document.querySelector('button[type="submit"]');

            if (uploadZone.style.display !== 'none') {
                // Add loading state to upload zone if no image selected
                uploadZone.style.opacity = '0.7';
                uploadZone.style.pointerEvents = 'none';
            }

            // Add loading state to submit button
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ri-loader-4-line me-1 spinner-border spinner-border-sm"></i> Menyimpan...';
            }
        });
    </script>
@endpush
