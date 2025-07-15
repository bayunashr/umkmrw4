@extends('layouts.umkm')

@section('title', 'Detail Foto Galeri - Banjarsugihan UMKM Digital Map')

@section('content')
<!-- Breadcrumb -->
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('umkm.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('umkm.gallery') }}">Galeri</a>
            </li>
            <li class="breadcrumb-item active">Detail Foto</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <!-- Gallery Image -->
    <div class="col-lg-8">
        <div class="card h-100">
            @if($gallery->image_path && file_exists(public_path('storage/' . $gallery->image_path)))
            <div class="card-img-top position-relative">
                <img src="{{ asset('storage/' . $gallery->image_path) }}"
                     alt="Foto Galeri"
                     class="img-fluid w-100"
                     style="height: 500px; object-fit: cover; border-radius: var(--bs-card-border-radius) var(--bs-card-border-radius) 0 0;">

                <!-- Image Actions Overlay -->
                <div class="position-absolute top-0 end-0 p-3">
                    <div class="btn-group-vertical" role="group">
                        <button type="button" class="btn btn-sm btn-dark bg-dark bg-opacity-75 border-0 mb-2"
                                onclick="viewImageFullscreen()" title="Lihat Gambar Penuh">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                        <a href="{{ asset('storage/' . $gallery->image_path) }}"
                           class="btn btn-sm btn-dark bg-dark bg-opacity-75 border-0"
                           download="{{ basename($gallery->image_path) }}"
                           title="Download Foto">
                            <i class="ri-download-line"></i>
                        </a>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="position-absolute bottom-0 start-0 p-3">
                            <span class="badge bg-success bg-opacity-90">
                                <i class="ri-gallery-line me-1"></i>Foto Galeri
                            </span>
                </div>
            </div>
            @else
            <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                 style="height: 500px; border-radius: var(--bs-card-border-radius) var(--bs-card-border-radius) 0 0;">
                <div class="text-center text-muted p-4">
                    <i class="ri-image-line mb-3" style="font-size: 64px;"></i>
                    <h6 class="mb-2">Foto tidak ditemukan</h6>
                    <p class="mb-0 small">File foto mungkin telah dihapus atau dipindahkan</p>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('umkm.gallery.edit', $gallery->id) }}"
                       class="btn btn-outline-primary">
                        <i class="ri-edit-line me-2"></i>
                        Edit Foto
                    </a>
                    <button type="button"
                            class="btn btn-outline-danger"
                            onclick="confirmDelete({{ $gallery->id }})">
                        <i class="ri-delete-bin-line me-2"></i>
                        Hapus Foto
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Details -->
    <div class="col-lg-4">
        <!-- Header -->
        <div class="card mb-4">
            <div class="card-body">
                <!-- Back Button -->
                <div class="mb-3">
                    <a href="{{ route('umkm.gallery') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="ri-arrow-go-back-line me-1"></i>
                        Kembali ke Galeri
                    </a>
                </div>

                <!-- Gallery Title -->
                <h4 class="mb-3">Foto Galeri</h4>

                <!-- Meta Information -->
                <div class="d-flex flex-wrap gap-3 text-muted">
                    <small>
                        <i class="ri-calendar-line me-1"></i>
                        Ditambahkan {{ $gallery->created_at->diffForHumans() }}
                    </small>
                    @if($gallery->updated_at != $gallery->created_at)
                    <small>
                        <i class="ri-refresh-line me-1"></i>
                        Diupdate {{ $gallery->updated_at->diffForHumans() }}
                    </small>
                    @endif
                </div>
            </div>
        </div>

        <!-- Gallery Information -->
        <div class="card mb-4">
            <div class="card-header mb-4">
                <h5 class="mb-0">
                    <i class="ri-information-line me-2"></i>
                    Informasi Foto
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold text-muted small">KETERANGAN</label>
                        @if($gallery->caption)
                        <div class="bg-light rounded p-3 mt-2">
                            <p class="mb-0 lh-base">{{ $gallery->caption }}</p>
                        </div>
                        @else
                        <p class="text-muted fst-italic">Tidak ada keterangan</p>
                        @endif
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold text-muted small">STATUS FILE</label>
                        <div>
                            @if($gallery->image_path && file_exists(public_path('storage/' . $gallery->image_path)))
                            <span class="badge bg-primary">
                                        <i class="ri-check-line me-1"></i>File tersedia
                                    </span>
                            @else
                            <span class="badge bg-danger">
                                        <i class="ri-error-warning-line me-1"></i>File tidak ditemukan
                                    </span>
                            @endif
                        </div>
                    </div>

                    @if($gallery->image_path && file_exists(public_path('storage/' . $gallery->image_path)))
                    <div class="col-12">
                        <label class="form-label fw-semibold text-muted small">DETAIL FILE</label>
                        <div class="small">
                            <div class="mb-1">
                                <strong>Nama File:</strong> {{ basename($gallery->image_path) }}
                            </div>
                            <div class="mb-1">
                                <strong>Format:</strong> {{ strtoupper(pathinfo($gallery->image_path, PATHINFO_EXTENSION)) }}
                            </div>
                            <div class="mb-1">
                                <strong>Ukuran:</strong> {{ number_format(filesize(public_path('storage/' . $gallery->image_path)) / 1024, 2) }} KB
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Metadata -->
        <div class="card">
            <div class="card-header mb-4">
                <h5 class="mb-0">
                    <i class="ri-time-line me-2"></i>
                    Riwayat Waktu
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold text-muted small">DITAMBAHKAN</label>
                        <div>
                            <div class="fw-medium">
                                <i class="ri-calendar-line me-1"></i>
                                {{ $gallery->created_at->format('d M Y, H:i') }} WIB
                            </div>
                            <small class="text-muted">{{ $gallery->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold text-muted small">TERAKHIR DIUPDATE</label>
                        <div>
                            <div class="fw-medium">
                                <i class="ri-refresh-line me-1"></i>
                                {{ $gallery->updated_at->format('d M Y, H:i') }} WIB
                            </div>
                            <small class="text-muted">{{ $gallery->updated_at->diffForHumans() }}</small>
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
                    Konfirmasi Hapus Foto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="ri-error-warning-line text-warning" style="font-size: 48px;"></i>
                </div>
                <p class="text-center mb-0">
                    Apakah Anda yakin ingin menghapus foto ini dari galeri?
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
                <form method="POST" action="{{ route('umkm.gallery.destroy', $gallery->id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="ri-delete-bin-line me-1"></i>
                        Ya, Hapus Foto
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Fullscreen Modal -->
@if($gallery->image_path && file_exists(public_path('storage/' . $gallery->image_path)))
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto Galeri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <img src="{{ asset('storage/' . $gallery->image_path) }}"
                     alt="Foto Galeri"
                     class="img-fluid w-100">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i>
                    Tutup
                </button>
                <a href="{{ asset('storage/' . $gallery->image_path) }}"
                   class="btn btn-primary"
                   download="{{ basename($gallery->image_path) }}">
                    <i class="ri-download-line me-1"></i>
                    Download
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('js')
<script>
    function confirmDelete(galleryId) {
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
        .col-lg-8 {
            order: 1;
        }

        .col-lg-4 {
            order: 0;
        }
    }

    @media (max-width: 576px) {
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 0.5rem !important;
        }

        .card-img-top {
            height: 300px !important;
        }
    }
</style>
@endpush
