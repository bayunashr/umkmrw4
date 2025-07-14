@extends('layouts.umkm')

@section('title', 'Edit Produk - ' . $product->name)

@section('content')
    <div class="card mb-6">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between mb-lg-4">
            <div class="flex-grow-0 me-md-3">
                <a href="{{ route('umkm.product.show', $product->id) }}" class="btn btn-outline-secondary btn-sm">
                    <span class="ri-arrow-go-back-fill me-1"></span> Kembali ke Detail
                </a>
            </div>
            <div class="flex-grow-1 text-center text-md-start mt-2 mt-md-0">
                <h5 class="mb-0">Edit Produk & Layanan</h5>
                <small class="text-muted">Perbarui informasi produk "{{ $product->name }}"</small>
            </div>
        </div>

        <form class="card-body" method="POST" action="{{ route('umkm.product.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                                value="{{ old('name', $product->name) }}"
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
                                value="{{ old('price', $product->price) }}"
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
                            >{{ old('description', $product->description) }}</textarea>
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
                        Gambar Produk <small class="text-muted">(opsional)</small>
                    </label>

                    <!-- Current Image Display -->
                    @if($product->image_path && file_exists(public_path('storage/' . $product->image_path)))
                        <div class="mb-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary-subtle bg-opacity-10 mb-4">
                                    <h6 class="mb-0">
                                        <i class="ri-image-line me-2"></i>
                                        Gambar Saat Ini
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <img src="{{ asset('storage/' . $product->image_path) }}"
                                                 alt="{{ $product->name }}"
                                                 class="rounded border"
                                                 style="width: 120px; height: 120px; object-fit: cover;">
                                        </div>
                                        <div class="col">
                                            <h6 class="mb-2">{{ basename($product->image_path) }}</h6>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <span class="badge bg-success rounded">
                                                    <i class="ri-check-line me-1"></i>Gambar aktif
                                                </span>
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                        onclick="viewCurrentImage()">
                                                    <i class="ri-eye-line me-1"></i>Lihat Penuh
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmRemoveCurrentImage()">
                                                    <i class="ri-delete-bin-line me-1"></i>Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mb-4">
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="ri-information-line me-2"></i>
                                <span>Produk ini belum memiliki gambar. Tambahkan gambar untuk menarik perhatian pembeli.</span>
                            </div>
                        </div>
                    @endif

                    <div class="upload-area">
                        <!-- File Input -->
                        <input
                            type="file"
                            name="image"
                            id="imageInput"
                            class="d-none @error('image') is-invalid @enderror"
                            accept="image/jpeg,image/jpg,image/png"
                        >

                        <!-- Upload Zone -->
                        <div id="uploadZone" class="upload-zone" onclick="document.getElementById('imageInput').click()">
                            <div class="upload-content text-center">
                                <div class="upload-icon mb-3">
                                    <i class="ri-upload-cloud-2-line" id="uploadIcon"></i>
                                </div>
                                <h6 class="upload-title mb-2" id="uploadTitle">
                                    @if($product->image_path)
                                        Ganti gambar produk
                                    @else
                                        Pilih gambar produk
                                    @endif
                                </h6>
                                <p class="upload-subtitle text-muted mb-0" id="uploadSubtitle">
                                    Format: JPG, PNG, JPEG • Maksimal: 5MB
                                </p>
                            </div>
                        </div>

                        <!-- New Image Preview -->
                        <div id="imagePreview" class="image-preview-container" style="display: none;">
                            <div class="alert alert-warning d-flex align-items-center mb-3">
                                <i class="ri-information-line me-2"></i>
                                <span><strong>Gambar baru dipilih!</strong> Gambar ini akan mengganti gambar yang ada saat ini.</span>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="preview-wrapper">
                                        <img id="previewImage" class="preview-img" src="" alt="Preview">
                                        <div class="preview-overlay">
                                            <button type="button" class="btn-remove" onclick="removeNewImage()" title="Hapus gambar baru">
                                                <i class="ri-close-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 d-flex flex-column justify-content-center">
                                    <div class="image-info">
                                        <h6 class="mb-2"><i class="ri-file-image-line me-2"></i>Gambar Baru:</h6>
                                        <p class="mb-1"><strong>Nama:</strong> <span id="fileName">-</span></p>
                                        <p class="mb-1"><strong>Ukuran:</strong> <span id="fileSize">-</span></p>
                                        <div class="mt-2">
                                            <span class="badge bg-warning">
                                                <i class="ri-refresh-line me-1"></i>Akan mengganti gambar lama
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Error Messages -->
                        <div id="errorMessages"></div>
                    </div>

                    @error('image')
                    <div class="form-text text-danger mt-2">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror

                    <div class="form-text text-muted mt-2">
                        <i class="ri-information-line me-1"></i>
                        @if($product->image_path)
                            Biarkan kosong jika tidak ingin mengubah gambar yang sudah ada
                        @else
                            Gambar yang menarik akan membantu pembeli tertarik dengan produk Anda
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="pt-6">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <a href="{{ route('umkm.product.show', $product->id) }}" class="btn btn-outline-secondary w-100">
                            <i class="ri-arrow-go-back-line me-1"></i> Batal
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                            <i class="ri-save-line me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Current Image Modal -->
    @if($product->image_path && file_exists(public_path('storage/' . $product->image_path)))
        <div class="modal fade" id="currentImageModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Gambar Saat Ini - {{ $product->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="{{ asset('storage/' . $product->image_path) }}"
                             alt="{{ $product->name }}"
                             class="img-fluid w-100">
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Remove Current Image Confirmation Modal -->
    <div class="modal fade" id="removeImageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ri-delete-bin-line me-2 text-danger"></i>
                        Konfirmasi Hapus Gambar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="ri-image-off-line text-warning" style="font-size: 48px;"></i>
                    </div>
                    <p class="text-center mb-0">
                        Apakah Anda yakin ingin menghapus gambar produk ini?
                    </p>
                    <p class="text-center text-muted mt-2">
                        Produk akan tampil tanpa gambar setelah disimpan.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i>
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger" onclick="removeCurrentImage()">
                        <i class="ri-delete-bin-line me-1"></i>
                        Ya, Hapus Gambar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden input to track image removal -->
    <input type="hidden" id="removeCurrentImageFlag" name="remove_current_image" value="0">
@endsection

@push('css')
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

        .upload-zone.loading {
            pointer-events: none;
            opacity: 0.7;
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
            border: 2px solid #f59e0b;
            border-radius: 16px;
            background: #fffbeb;
            padding: 16px;
        }

        .preview-wrapper {
            position: relative;
            width: 100%;
            height: 200px;
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
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

        .breadcrumb {
            background: none;
            padding: 0;
        }

        .breadcrumb-item a {
            text-decoration: none;
            color: var(--bs-primary);
        }

        .breadcrumb-item.active {
            color: var(--bs-secondary);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .spinning {
            animation: spin 1s linear infinite;
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

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('imageInput');
            const uploadZone = document.getElementById('uploadZone');
            const uploadIcon = document.getElementById('uploadIcon');
            const uploadTitle = document.getElementById('uploadTitle');
            const uploadSubtitle = document.getElementById('uploadSubtitle');
            const imagePreview = document.getElementById('imagePreview');
            const previewImage = document.getElementById('previewImage');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const errorMessages = document.getElementById('errorMessages');
            const submitBtn = document.getElementById('submitBtn');

            // Handle file selection
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                // Clear any previous errors
                clearErrors();

                if (!file) {
                    console.log('❌ No file selected');
                    return;
                }

                console.log('📁 File selected for replacement:', file.name);

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    showError('Format file tidak didukung. Gunakan JPG, PNG, atau JPEG.');
                    resetInput();
                    return;
                }

                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showError('Ukuran file terlalu besar. Maksimal 5MB.');
                    resetInput();
                    return;
                }

                // Show loading state
                showLoadingState();

                // Process file with slight delay for better UX
                setTimeout(() => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Update preview elements
                        previewImage.src = e.target.result;
                        fileName.textContent = file.name;
                        fileSize.textContent = formatFileSize(file.size);

                        // Hide upload zone and show preview
                        uploadZone.style.display = 'none';
                        imagePreview.style.display = 'block';

                        console.log('✅ New image preview loaded successfully');
                    };

                    reader.onerror = function() {
                        showError('Gagal membaca file. Coba pilih file lain.');
                        resetInput();
                    };

                    reader.readAsDataURL(file);
                }, 500);
            });

            // Handle form submission
            document.querySelector('form').addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ri-loader-4-line me-1 spinning"></i> Menyimpan Perubahan...';

                if (imageInput.files.length > 0) {
                    console.log('💾 Submitting form with new image:', imageInput.files[0].name);
                } else {
                    console.log('💾 Submitting form without image changes');
                }
            });

            function showLoadingState() {
                uploadZone.classList.add('loading');
                uploadIcon.className = 'ri-loader-4-line spinning';
                uploadTitle.textContent = 'Memproses gambar...';
                uploadSubtitle.textContent = 'Mohon tunggu sebentar';
            }

            function resetLoadingState() {
                uploadZone.classList.remove('loading');
                uploadIcon.className = 'ri-upload-cloud-2-line';
                uploadTitle.textContent = '{{ $product->image_path ? "Ganti gambar produk" : "Pilih gambar produk" }}';
                uploadSubtitle.textContent = 'Format: JPG, PNG, JPEG • Maksimal: 5MB';
            }

            function showError(message) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger d-flex align-items-center mt-3';
                errorDiv.innerHTML = `<i class="ri-error-warning-line me-2"></i><span>${message}</span>`;

                errorMessages.appendChild(errorDiv);

                // Auto hide after 5 seconds
                setTimeout(() => {
                    if (errorDiv.parentNode) {
                        errorDiv.remove();
                    }
                }, 5000);

                console.log('❌ Error:', message);
            }

            function clearErrors() {
                errorMessages.innerHTML = '';
            }

            function resetInput() {
                imageInput.value = '';
                resetLoadingState();
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Global functions for modal interactions
            window.removeNewImage = function() {
                imageInput.value = '';
                uploadZone.style.display = 'block';
                imagePreview.style.display = 'none';
                resetLoadingState();
                clearErrors();

                console.log('🗑️ New image removed');
            };

            window.viewCurrentImage = function() {
                const modal = new bootstrap.Modal(document.getElementById('currentImageModal'));
                modal.show();
            };

            window.confirmRemoveCurrentImage = function() {
                const modal = new bootstrap.Modal(document.getElementById('removeImageModal'));
                modal.show();
            };

            window.removeCurrentImage = function() {
                document.getElementById('removeCurrentImageFlag').value = '1';

                // Hide the current image display
                const currentImageCard = document.querySelector('.card.border-success');
                if (currentImageCard) {
                    currentImageCard.style.display = 'none';
                }

                // Show info alert
                const infoAlert = document.createElement('div');
                infoAlert.className = 'alert alert-warning d-flex align-items-center mb-4';
                infoAlert.innerHTML = `
            <i class="ri-information-line me-2"></i>
            <span>Gambar saat ini akan dihapus saat form disimpan.</span>
        `;

                // Insert before upload area
                const uploadArea = document.querySelector('.upload-area');
                uploadArea.parentNode.insertBefore(infoAlert, uploadArea);

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('removeImageModal'));
                modal.hide();

                console.log('🗑️ Current image marked for removal');
            };

            console.log('🚀 Edit product script initialized');
        });
    </script>
@endpush
