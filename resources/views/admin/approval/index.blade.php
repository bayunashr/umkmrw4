@extends('layouts.admin')

@section('title', 'Persetujuan UMKM - Banjarsugihan UMKM Digital Map')

@section('content')
    @if (session('success'))
        <div class="alert alert-solid-primary d-flex align-items-center alert-dismissible" role="alert">
            <span class="alert-icon rounded">
              <i class="ri-user-follow-fill ri-22px"></i>
            </span>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <h5 class="card-header text-center text-md-start mb-md-n5">Persetujuan UMKM</h5>
        <div class="card-datatable table-responsive pt-0">
            <table class="table table-bordered datatables-approval-umkm">
                <thead>
                <tr>
                    <th style="width: 1%; white-space: nowrap;">No</th>
                    <th>Nama</th>
                    <th>Pemilik</th>
                    <th>Telepon</th>
                    <th>Status</th>
                    <th style="width: 1%; white-space: nowrap;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($pendingUmkm as $i => $umkm)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $umkm->name }}</td>
                        <td>{{ $umkm->user->name }}</td>
                        <td>{{ $umkm->phone }}</td>
                        <td>
                            <span class="badge bg-label-warning">Pending</span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <a href="{{ route('admin.approval.show', $umkm->id) }}" class="btn btn-info btn-sm d-flex justify-content-center align-items-center">
                                    <span class="ri-eye-fill"></span>
                                </a>
                                <form class="form-approve" action="{{ route('admin.approval.approve', $umkm->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm d-flex justify-content-center align-items-center">
                                        <span class="ri-checkbox-circle-fill"></span>
                                    </button>
                                </form>
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
            const dtTable = $('.datatables-approval-umkm');

            if (dtTable.length) {
                const dt = dtTable.DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr',
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function (row) {
                                    const data = row.data();
                                    return 'Detail UMKM ' + data[1];
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
                            targets: 5,
                            orderable: false,
                            searchable: false,
                        }
                    ],
                    dom: '<"row mx-1 mt-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center"f>>' +
                        '<"table-responsive"t>' +
                        '<"row mx-1"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center"p>>',
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
