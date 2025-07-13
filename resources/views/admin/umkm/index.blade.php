@extends('layouts.admin')

@section('title', 'Data UMKM - Banjarsugihan UMKM Digital Map')

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
                    <th>Pemilik</th>
                    <th>Telepon</th>
                    <th style="width: 1%; white-space: nowrap;">RT</th>
                    <th style="width: 1%; white-space: nowrap;">RW</th>
                    <th>Alamat</th>
                    <th>Deskripsi</th>
                    <th style="width: 1%; white-space: nowrap;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($allUmkm as $i => $umkm)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar me-2">
                                        @if($umkm->avatar && file_exists(public_path('storage/avatars/' . $umkm->avatar)))
                                            <img src="{{ asset('storage/avatars/' . $umkm->avatar) }}" alt="Avatar"
                                                 class="rounded" width="40" height="40">
                                        @else
                                            @php
                                                $initials = collect(explode(' ', $umkm->name))
                                                    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                                    ->join('');
                                                $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info'];
                                                $color = $colors[crc32($umkm->name) % count($colors)];
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-center bg-label-{{ $color }}"
                                                 style="width: 40px; height: 40px; border-radius: .5rem; font-weight: bold;">
                                                {{ $initials }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-truncate text-heading">{{ $umkm->name }}</span>
                                    <small class="text-truncate">{{ $umkm->owner_name }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $umkm->user->name }}</td>
                        <td>{{ $umkm->phone }}</td>
                        <td>{{ $umkm->rt ? $umkm->rt : '-' }}</td>
                        <td>{{ $umkm->rw ? $umkm->rw : '-' }}</td>
                        <td>{{ $umkm->address ? $umkm->address : '-' }}</td>
                        <td>{{ $umkm->description ? $umkm->description : '-' }}</td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <a href="{{ route('admin.umkm.show', $umkm->slug) }}" class="btn btn-info btn-sm d-flex justify-content-center align-items-center">
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
                                    return 'Detail UMKM';
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
                            targets: 0,
                            orderable: false,
                            searchable: false,
                            responsivePriority: 1
                        },
                        {
                            targets: 8,
                            orderable: false,
                            searchable: false,
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
                                    exportOptions: {
                                        columns: [3, 4, 5, 6, 7],
                                        // prevent avatar to be display
                                        format: {
                                            body: function (inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function (index, item) {
                                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                        result = result + item.lastChild.firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    },
                                    customize: function (win) {
                                        //customize print view for dark
                                        $(win.document.body)
                                            .css('color', config.colors.headingColor)
                                            .css('border-color', config.colors.borderColor)
                                            .css('background-color', config.colors.bodyBg);
                                        $(win.document.body)
                                            .find('table')
                                            .addClass('compact')
                                            .css('color', 'inherit')
                                            .css('border-color', 'inherit')
                                            .css('background-color', 'inherit');
                                    }
                                },
                                {
                                    extend: 'csv',
                                    text: '<i class="ri-file-text-line me-1" ></i>Csv',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [3, 4, 5, 6, 7],
                                        // prevent avatar to be display
                                        format: {
                                            body: function (inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function (index, item) {
                                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                        result = result + item.lastChild.firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                },
                                {
                                    extend: 'excel',
                                    text: '<i class="ri-file-excel-line me-1"></i>Excel',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [3, 4, 5, 6, 7],
                                        // prevent avatar to be display
                                        format: {
                                            body: function (inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function (index, item) {
                                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                        result = result + item.lastChild.firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [3, 4, 5, 6, 7],
                                        // prevent avatar to be display
                                        format: {
                                            body: function (inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function (index, item) {
                                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                        result = result + item.lastChild.firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                },
                                {
                                    extend: 'copy',
                                    text: '<i class="ri-file-copy-line me-1" ></i>Copy',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [3, 4, 5, 6, 7],
                                        // prevent avatar to be display
                                        format: {
                                            body: function (inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function (index, item) {
                                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                        result = result + item.lastChild.firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                }
                            ]
                        },
                        {
                            text: '<i class="ri-add-line ri-16px me-sm-2"></i> <span class="d-none d-sm-inline-block">Tambah Data Baru</span>',
                            className: 'create-new btn btn-primary waves-effect waves-light',
                            action: function (e, dt, node, config) {
                                window.location.href = '{{ route('admin.umkm.create') }}';
                            }
                        }
                    ],
                    dom: '<"card-header flex-column flex-md-row border-bottom"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6 mt-5 mt-md-0"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    language: {
                        paginate: {
                            next: '<i class="ri-arrow-right-s-line"></i>',
                            previous: '<i class="ri-arrow-left-s-line"></i>'
                        },
                        lengthMenu: "Tampilkan _MENU_ data",
                        zeroRecords: "Tidak ada data yang ditemukan",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0 data",
                        infoFiltered: "(disaring dari total _MAX_ entri)",
                        search: "Cari:",
                        emptyTable: "Tidak ada data dalam tabel"
                    }
                });
                $('div.head-label').html('<h5 class="card-title mb-0">Data UMKM</h5>');

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
