@extends('layouts.umkm')

@section('title', 'Tambah Foto Galeri - Banjarsugihan UMKM Digital Map')

@section('content')
    <div class="card mb-6">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between mb-lg-4">
            <div class="flex-grow-0 me-md-3">
                <a href="{{ route('umkm.gallery') }}" class="btn btn-outline-secondary btn-sm">
                    <span class="ri-arrow-go-back-fill me-1"></span> Kembali
                </a>
            </div>
            <div class="flex-grow-1 text-center text-md-start mt-2 mt-md-0">
                <h5 class="mb-0">Tambah Foto Galeri</h5>
                <small class="text-muted">Upload foto untuk menampilkan galeri UMKM Anda</small>
            </div>
        </div>

        <form class="card-body" method="POST" action="{{ route('umkm.gallery.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-6">
                {{-- Upload Gambar --}}
                <div class="col-12">
                    <label class="form-label mb-3">
                        <i class="ri-image-line me-2"></i>
                        Foto <span class="text-danger">*</span>
                    </label>

                    <div class="upload-area">
                        <!-- File Input -->
                        <input
                            type="file"
                            name="image"
                            id="imageInput"
                            class="d-none @error('image') is-invalid @enderror"
                            accept="image/jpeg,image/jpg,image/png"
                            required
                        >

                        <!-- Upload Zone -->
                        <div id="uploadZone" class="upload-zone" onclick="document.getElementById('imageInput').click()">
                            <div class="upload-content text-center">
                                <div class="upload-icon mb-3">
                                    <i class="ri-upload-cloud-2-line" id="uploadIcon"></i>
                                </div>
                                <h6 class="upload-title mb-2" id="uploadTitle">Klik untuk pilih foto</h6>
                                <p class="upload-subtitle text-muted mb-0" id="uploadSubtitle">
                                    Format: JPG, PNG, JPEG • Maksimal: 5MB
                                </p>
                            </div>
                        </div>

                        <!-- Image Preview -->
                        <div id="imagePreview" class="image-preview-container" style="display: none;">
                            <div class="alert alert-success d-flex align-items-center mb-3">
                                <i class="ri-check-circle-line me-2"></i>
                                <span><strong>Foto berhasil dipilih!</strong> Siap untuk disimpan.</span>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="preview-wrapper">
                                        <img id="previewImage" class="preview-img" src="" alt="Preview">
                                        <div class="preview-overlay">
                                            <button type="button" class="btn-remove" onclick="removeImage()" title="Hapus foto">
                                                <i class="ri-close-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 d-flex flex-column justify-content-center">
                                    <div class="image-info">
                                        <h6 class="mb-2"><i class="ri-file-image-line me-2"></i>Detail Foto:</h6>
                                        <p class="mb-1"><strong>Nama:</strong> <span id="fileName">-</span></p>
                                        <p class="mb-1"><strong>Ukuran:</strong> <span id="fileSize">-</span></p>
                                        <div class="mt-2">
                                            <span class="badge bg-success">
                                                <i class="ri-check-line me-1"></i>Siap untuk disimpan
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
                </div>

                {{-- Caption/Keterangan --}}
                <div class="col-12">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text align-items-start pt-3"><i class="ri-text"></i></span>
                        <div class="form-floating form-floating-outline">
                            <textarea
                                name="caption"
                                class="form-control @error('caption') is-invalid @enderror"
                                placeholder="Keterangan foto"
                                style="height: 120px"
                            >{{ old('caption') }}</textarea>
                            <label>Keterangan Foto (opsional)</label>
                        </div>
                    </div>
                    @error('caption')
                    <div class="invalid-feedback d-block">
                        <i class="ri-error-warning-line me-1"></i>{{ $message }}
                    </div>
                    @enderror

                    <div class="form-text mt-2">
                        <i class="ri-information-line me-1"></i>
                        Tambahkan keterangan untuk menjelaskan foto ini
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="pt-6">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <a href="{{ route('umkm.gallery') }}" class="btn btn-outline-secondary w-100">
                            <i class="ri-arrow-go-back-line me-1"></i> Batal
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                            <i class="ri-save-line me-1"></i> Simpan Foto
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('css')
    <style>
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

                console.log('📁 File selected:', file.name);

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

                        console.log('✅ Image preview loaded successfully');
                    };

                    reader.onerror = function() {
                        showError('Gagal membaca file. Coba pilih file lain.');
                        resetInput();
                    };

                    reader.readAsDataURL(file);
                }, 500);
            });

            // Handle form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                // Validate required image
                if (!imageInput.files.length) {
                    e.preventDefault();
                    showError('Silakan pilih foto terlebih dahulu.');
                    return false;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ri-loader-4-line me-1 spinning"></i> Menyimpan Foto...';

                console.log('💾 Submitting form with image:', imageInput.files[0].name);
            });

            function showLoadingState() {
                uploadZone.classList.add('loading');
                uploadIcon.className = 'ri-loader-4-line spinning';
                uploadTitle.textContent = 'Memproses foto...';
                uploadSubtitle.textContent = 'Mohon tunggu sebentar';
            }

            function resetLoadingState() {
                uploadZone.classList.remove('loading');
                uploadIcon.className = 'ri-upload-cloud-2-line';
                uploadTitle.textContent = 'Klik untuk pilih foto';
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

            // Make removeImage function global
            window.removeImage = function() {
                if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                    imageInput.value = '';
                    uploadZone.style.display = 'block';
                    imagePreview.style.display = 'none';
                    resetLoadingState();
                    clearErrors();

                    console.log('🗑️ Image removed');
                }
            };

            console.log('🚀 Gallery upload script initialized');
        });
    </script>
@endpush
