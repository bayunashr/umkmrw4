@extends('layouts.umkm')

@section('title', 'Produk Saya - Banjarsugihan UMKM Digital Map')

@section('content')
    @if (session('success'))
        <div class="alert alert-solid-primary d-flex align-items-center alert-dismissible" role="alert">
            <span class="alert-icon rounded">
              <i class="ri-checkbox-circle-fill ri-22px"></i>
            </span>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="table table-bordered datatables-data-umkm">
                <thead>
                <tr>
                    <th style="width: 1%; white-space: nowrap;">No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th style="width: 1%; white-space: nowrap;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $i => $product)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar me-2">
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="Avatar"
                                             class="rounded" width="40" height="40">
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-truncate text-heading">{{ $product->name }}</span>
                                    <small class="text-truncate">{{ $product->name }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <a href="" class="btn btn-info btn-sm d-flex justify-content-center align-items-center">
                                    <span class="ri-eye-fill"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
                                    const data = row.data();
                                    return 'Detail Produk';
                                }
                            }),
                            renderer: function (api, rowIdx, columns) {
                                const data = $.map(columns, function (col) {
                                    return col.title
                                        ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                                        <td>${col.title}</td>
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
                            targets: 4, // Kolom "Aksi"
                            orderable: false,
                            searchable: false,
                            responsivePriority: 2
                        }
                    ],
                    buttons: [
                        {
                            extend: 'collection',
                            className: 'btn btn-label-primary dropdown-toggle me-4 waves-effect waves-light',
                            text: '<i class="ri-external-link-line me-sm-1"></i> <span class="d-none d-sm-inline-block">Ekspor</span>',
                            buttons: [
                                {
                                    extend: 'print',
                                    text: '<i class="ri-printer-line me-1" ></i>Print',
                                    className: 'dropdown-item',
                                    exportOptions: { columns: [1, 2, 3] }
                                },
                                {
                                    extend: 'csv',
                                    text: '<i class="ri-file-text-line me-1" ></i>CSV',
                                    className: 'dropdown-item',
                                    exportOptions: { columns: [1, 2, 3] }
                                },
                                {
                                    extend: 'excel',
                                    text: '<i class="ri-file-excel-line me-1" ></i>Excel',
                                    className: 'dropdown-item',
                                    exportOptions: { columns: [1, 2, 3] }
                                },
                                {
                                    extend: 'pdf',
                                    text: '<i class="ri-file-pdf-line me-1" ></i>PDF',
                                    className: 'dropdown-item',
                                    exportOptions: { columns: [1, 2, 3] }
                                },
                                {
                                    extend: 'copy',
                                    text: '<i class="ri-file-copy-line me-1" ></i>Salin',
                                    className: 'dropdown-item',
                                    exportOptions: { columns: [1, 2, 3] }
                                }
                            ]
                        },
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

                dtTable.on('click', 'a, button', function (e) {
                    e.stopPropagation();
                    if ($(this).is('a')) {
                        e.preventDefault();
                        window.location.href = $(this).attr('href');
                    }
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('submit', function (e) {
                const form = e.target;
                if (form.classList.contains('form-approve')) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Yakin ingin menyetujui?',
                        text: "UMKM ini akan disetujui dan tidak bisa dibatalkan.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Setujui!',
                        cancelButtonText: 'Batal',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                            cancelButton: 'btn btn-outline-secondary waves-effect'
                        },
                        buttonsStyling: false
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
@endpush
