@extends('layouts.umkm')

@section('title', 'Produk Saya - Banjarsugihan UMKM Digital Map')

@section('content')
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="table table-bordered datatables-data-umkm">
                <thead>
                <tr>
                    <th style="width: 1%; white-space: nowrap;">No</th>
                    <th>Produk</th>
                    <th>Deskripsi</th>
                    <th style="width: 15%; white-space: nowrap;">Harga</th>
                    <th style="width: 1%; white-space: nowrap;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($products as $i => $product)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar me-3">
                                        @if($product->image_path && file_exists(public_path('storage/' . $product->image_path)))
                                            <img src="{{ Storage::url($product->image_path) }}"
                                                 alt="{{ $product->name }}"
                                                 class="rounded"
                                                 width="40"
                                                 height="40"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="avatar-initial rounded bg-light d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px;">
                                                <i class="ri-image-line text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-truncate text-heading fw-semibold">{{ $product->name }}</span>
                                    <small class="text-muted">
                                        <i class="ri-calendar-line me-1"></i>
                                        {{ $product->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 300px;" title="{{ $product->description }}">
                                {{ Str::limit($product->description, 100) }}
                            </div>
                        </td>
                        <td>
                            @if($product->price)
                                <span class="fw-semibold text-primary">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="badge bg-label-secondary">
                                    <i class="ri-price-tag-3-line me-1"></i>
                                    Belum ditentukan
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-line ri-20px"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('umkm.product.show', $product->id) }}">
                                            <i class="ri-eye-line me-2"></i>
                                            Lihat Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('umkm.product.edit', $product->id) }}">
                                            <i class="ri-edit-line me-2"></i>
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item text-danger"
                                                onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')">
                                            <i class="ri-delete-bin-line me-2"></i>
                                            Hapus
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state">
                                <i class="ri-shopping-bag-line text-muted" style="font-size: 48px;"></i>
                                <h6 class="mt-3 mb-1">Belum Ada Produk</h6>
                                <p class="text-muted mb-3">Tambahkan produk pertama Anda untuk mulai berjualan</p>
                                <a href="{{ route('umkm.product.create') }}" class="btn btn-primary">
                                    <i class="ri-add-line me-1"></i>
                                    Tambah Produk
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
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
                        Apakah Anda yakin ingin menghapus produk <strong id="productName"></strong>?
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
                    <form method="POST" action="" id="deleteForm" class="d-inline">
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
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/sweetalert2/sweetalert2.css" />

    <style>
        .empty-state {
            padding: 2rem 1rem;
        }

        .avatar-initial {
            background-color: #f8f9fa !important;
            border: 1px solid #e9ecef;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* DataTable responsive improvements */
        @media (max-width: 768px) {
            .datatables-data-umkm th:nth-child(3),
            .datatables-data-umkm td:nth-child(3) {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .datatables-data-umkm th:nth-child(4),
            .datatables-data-umkm td:nth-child(4) {
                display: none;
            }
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('') }}assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <script>
        $(function () {
            const dtTable = $('.datatables-data-umkm');

            if (dtTable.length) {
                const dt = dtTable.DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr',
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function (row) {
                                    return 'Detail Produk';
                                }
                            }),
                            renderer: function (api, rowIdx, columns) {
                                const data = $.map(columns, function (col) {
                                    return col.title
                                        ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                                        <td class="fw-semibold">${col.title}</td>
                                        <td>${col.data}</td>
                                   </tr>`
                                        : '';
                                }).join('');
                                return data ? $('<table class="table"/><tbody />').append(data) : false;
                            }
                        }
                    },
                    columnDefs: [
                        {
                            targets: 0, // Kolom "No"
                            orderable: false,
                            searchable: false,
                            responsivePriority: 1
                        },
                        {
                            targets: 1, // Kolom "Produk"
                            responsivePriority: 1
                        },
                        {
                            targets: 2, // Kolom "Deskripsi"
                            responsivePriority: 3
                        },
                        {
                            targets: 3, // Kolom "Harga"
                            responsivePriority: 2
                        },
                        {
                            targets: 4, // Kolom "Aksi"
                            orderable: false,
                            searchable: false,
                            responsivePriority: 1
                        }
                    ],
                    order: [[1, 'asc']], // Sort by product name by default
                    buttons: [
                        {
                            text: '<i class="ri-add-line ri-16px me-sm-2"></i> <span class="d-none d-sm-inline-block">Tambah Produk / Layanan</span>',
                            className: 'create-new btn btn-primary waves-effect waves-light',
                            action: function () {
                                window.location.href = '{{ route('umkm.product.create') }}';
                            }
                        }
                    ],
                    dom: '<"card-header flex-column flex-md-row border-bottom"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6 mt-5 mt-md-0"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    language: {
                        paginate: {
                            next: '<i class="ri-arrow-right-s-line"></i>',
                            previous: '<i class="ri-arrow-left-s-line"></i>'
                        },
                        lengthMenu: "Tampilkan _MENU_ produk",
                        zeroRecords: "Tidak ada produk ditemukan",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ produk",
                        infoEmpty: "Menampilkan 0 produk",
                        infoFiltered: "(disaring dari total _MAX_ produk)",
                        search: "Cari:",
                        emptyTable: "Belum ada produk ditambahkan"
                    }
                });

                $('div.head-label').html('<h5 class="card-title mb-0">Daftar Produk & Layanan</h5>');

                // Prevent event bubbling for action buttons
                dtTable.on('click', 'a, button', function (e) {
                    e.stopPropagation();
                });
            }
        });

        // Delete confirmation function
        function confirmDelete(productId, productName) {
            document.getElementById('productName').textContent = `"${productName}"`;

            // Build the correct delete URL
            const deleteUrl = "{{ route('umkm.product.destroy', ':id') }}".replace(':id', productId);
            document.getElementById('deleteForm').action = deleteUrl;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Auto-hide success/error messages
        document.addEventListener('DOMContentLoaded', function () {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('alert-success') || alert.classList.contains('alert-danger')) {
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
