@extends('layouts.umkm')

@section('title', 'Detail Produk - ' . $product->name)

@section('content')

    <div class="row g-4">
        <!-- Product Image -->
        <div class="col-lg-5">
            <div class="card h-100">
                @if($product->image_path && file_exists(public_path('storage/' . $product->image_path)))
                    <div class="card-img-top position-relative">
                        <img src="{{ asset('storage/' . $product->image_path) }}"
                             alt="{{ $product->name }}"
                             class="img-fluid w-100"
                             style="height: 400px; object-fit: cover; border-radius: var(--bs-card-border-radius) var(--bs-card-border-radius) 0 0;">

                        <!-- Image Actions Overlay -->
                        <div class="position-absolute top-0 end-0 p-3">
                            <div class="btn-group-vertical" role="group">
                                <button type="button" class="btn btn-sm btn-dark bg-dark bg-opacity-75 border-0 mb-2"
                                        onclick="viewImageFullscreen()" title="Lihat Gambar Penuh">
                                    <i class="ri-fullscreen-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                         style="height: 400px; border-radius: var(--bs-card-border-radius) var(--bs-card-border-radius) 0 0;">
                        <div class="text-center text-muted p-4">
                            <i class="ri-image-line mb-3" style="font-size: 64px;"></i>
                            <h6 class="mb-2">Tidak ada gambar</h6>
                            <p class="mb-0 small">Tambahkan gambar untuk menarik perhatian pembeli</p>
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('umkm.product.edit', $product->id) }}"
                           class="btn btn-primary">
                            <i class="ri-edit-line me-2"></i>
                            Edit Produk
                        </a>
                        <button type="button"
                                class="btn btn-outline-danger"
                                onclick="confirmDelete({{ $product->id }})">
                            <i class="ri-delete-bin-line me-2"></i>
                            Hapus Produk
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-7">
            <!-- Header Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Back Button -->
                    <div class="mb-3">
                        <a href="{{ route('umkm.product') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="ri-arrow-go-back-line me-1"></i>
                            Kembali ke Daftar Produk
                        </a>
                    </div>

                    <!-- Product Title & Price -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $product->name }}</h3>

                            <!-- Price -->
                            @if($product->price)
                                <h4 class="text-primary mb-0">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </h4>
                            @else
                                <span class="badge bg-info fs-6 px-3 py-2">
                                    <i class="ri-price-tag-3-line me-1"></i>
                                    Harga belum ditentukan
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ri-information-line me-2"></i>
                        Informasi Produk
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted small mt-4">NAMA PRODUK</label>
                            <p class="mb-0 fs-6">{{ $product->name }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small">HARGA</label>
                            <div>
                                @if($product->price)
                                    <span class="text-primary fw-bold fs-5">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-muted">Belum ditentukan</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small">STATUS GAMBAR</label>
                            <div>
                                @if($product->image_path && file_exists(public_path('storage/' . $product->image_path)))
                                    <span class="badge bg-success">
                                        <i class="ri-check-line me-1"></i>Ada gambar
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="ri-error-warning-line me-1"></i>Belum ada gambar
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted small">DESKRIPSI</label>
                            <div class="bg-light rounded p-3 mt-2">
                                <p class="mb-0 lh-base" style="white-space: pre-line;">{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ri-time-line me-2"></i>
                        Riwayat Waktu
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mt-4">DIBUAT</label>
                            <div>
                                <div class="fw-medium">
                                    <i class="ri-calendar-line me-1"></i>
                                    {{ $product->created_at->format('d M Y, H:i') }} WIB
                                </div>
                                <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted small mt-4">TERAKHIR DIUPDATE</label>
                            <div>
                                <div class="fw-medium">
                                    <i class="ri-refresh-line me-1"></i>
                                    {{ $product->updated_at->format('d M Y, H:i') }} WIB
                                </div>
                                <small class="text-muted">{{ $product->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ri-delete-bin-line me-2 text-danger"></i>
                        Konfirmasi Hapus Produk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="ri-error-warning-line text-warning" style="font-size: 48px;"></i>
                    </div>
                    <p class="text-center mb-0">
                        Apakah Anda yakin ingin menghapus produk <strong>"{{ $product->name }}"</strong>?
                    </p>
                    <p class="text-center text-muted mt-2">
                        Tindakan ini tidak dapat dibatalkan!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i>
                        Batal
                    </button>
                    <form method="POST" action="{{ route('umkm.product.destroy', $product->id) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ri-delete-bin-line me-1"></i>
                            Ya, Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Fullscreen Modal -->
    @if($product->image_path && file_exists(public_path('storage/' . $product->image_path)))
        <div class="modal fade" id="imageModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $product->name }}</h5>
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
@endsection

@push('js')
    <script>
        function confirmDelete(productId) {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        function viewImageFullscreen() {
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('alert-success') || alert.classList.contains('alert-info')) {
                    setTimeout(() => {
                        alert.style.opacity = '0';
                        setTimeout(() => {
                            if (alert.parentNode) {
                                alert.remove();
                            }
                        }, 300);
                    }, 5000);
                }
            });
        });
    </script>
@endpush

@push('css')
    <style>
        .card {
            box-shadow: 0 0.125rem 0.375rem rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.15s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            font-weight: 600;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .bg-light {
            background-color: #f8f9fa !important;
            border: 1px solid #e9ecef;
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

        /* Image hover effects */
        .card-img-top {
            overflow: hidden;
        }

        .card-img-top img {
            transition: transform 0.3s ease;
        }

        .card:hover .card-img-top img {
            transform: scale(1.02);
        }

        /* Badge positioning */
        .position-absolute .badge {
            backdrop-filter: blur(10px);
        }

        /* Button improvements */
        .btn {
            transition: all 0.15s ease-in-out;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        /* Label styling */
        .form-label.small {
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .col-lg-5 {
                order: 1;
            }

            .col-lg-7 {
                order: 0;
            }
        }

        @media (max-width: 576px) {
            .d-flex.gap-3 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            .badge.fs-6 {
                font-size: 0.875rem !important;
            }
        }
    </style>
@endpush
