@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header p-3 d-flex align-items-center justify-content-start position-relative">
            <a href="{{ route('admin.approval') }}" class="btn btn-danger"><span class="ri-arrow-go-back-fill"></span></a>
            <h5 class="position-absolute top-50 start-50 translate-middle m-0">
                Detail UMKM {{ $pendingUmkm->name }}
            </h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
                <tbody class="table-border-bottom-0">
                    <tr>
                        <td style="width: 1%; white-space: nowrap;">
                            <i class="ri-store-2-line me-3"></i
                            ><span class="fw-medium">Nama</span>
                        </td>
                        <td>{{ $pendingUmkm->name }}</td>
                    </tr>
                    <tr>
                        <td style="width: 1%; white-space: nowrap;">
                            <i class="ri-user-4-line me-3"></i
                            ><span class="fw-medium">Pemilik</span>
                        </td>
                        <td>{{ $pendingUmkm->user->name }}</td>
                    </tr>
                    <tr>
                        <td style="width: 1%; white-space: nowrap;">
                            <i class="ri-user-smile-line me-3"></i
                            ><span class="fw-medium">Username</span>
                        </td>
                        <td>{{ $pendingUmkm->user->username }}</td>
                    </tr>
                    <tr>
                        <td style="width: 1%; white-space: nowrap;">
                            <i class="ri-smartphone-line me-3"></i
                            ><span class="fw-medium">Telepon</span>
                        </td>
                        <td>{{ $pendingUmkm->phone }}</td>
                    </tr>
                    <tr>
                        <td style="width: 1%; white-space: nowrap;">
                            <i class="ri-map-pin-5-line me-3"></i
                            ><span class="fw-medium">Lokasi</span>
                        </td>
                        <td>
                            <div id="map-umkm" style="height: 300px; width: 100%;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <form class="form-approve" action="{{ route('admin.approval.approve', $pendingUmkm->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-success btn-sm w-100">
                                    Setujui UMKM
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/leaflet/leaflet.css" />
@endpush

@push('js')
    <script src="{{ asset('') }}assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/leaflet/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lat = {{ $pendingUmkm->latitude ?? -7.2795 }};
            const lon = {{ $pendingUmkm->longitude ?? 112.6638 }};

            const map = L.map('map-umkm').setView([lat, lon], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap',
            }).addTo(map);

            L.marker([lat, lon]).addTo(map).bindPopup('Lokasi {{ $pendingUmkm->name }}').openPopup();
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
