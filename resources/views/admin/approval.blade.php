@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="table table-bordered datatables-basic">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Usaha</th>
                    <th>Nama Pemilik</th>
                    <th>Nomor HP</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($pendingUmkm as $i => $umkm)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $umkm->name }}</td>
                        <td>{{ $umkm->owner_name }}</td>
                        <td>{{ $umkm->phone }}</td>
                        <td>{{ $umkm->user->email ?? '-' }}</td>
                        <td>
                            <span class="badge bg-label-warning">Pending</span>
                        </td>
                        <td>
{{--                            <a href="{{ route('admin.umkm.show', $umkm->id) }}" class="btn btn-info btn-sm">Detail</a>--}}
{{--                            <form action="{{ route('admin.umkm.approve', $umkm->id) }}" method="POST" class="d-inline">--}}
{{--                                @csrf--}}
{{--                                @method('PUT')--}}
{{--                                <button class="btn btn-success btn-sm">Setujui</button>--}}
{{--                            </form>--}}
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
@endpush

@push('js')
    <script src="{{ asset('') }}assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <script>
        $(function () {
            $('.datatables-basic').DataTable({
                responsive: true,
                language: {
                    paginate: {
                        next: '<i class="ri-arrow-right-s-line"></i>',
                        previous: '<i class="ri-arrow-left-s-line"></i>'
                    }
                },
                dom: '<"row"<"col-md-6"l><"col-md-6 text-end"f>>t<"row"<"col-md-6"i><"col-md-6"p>>'
            });
        });
    </script>
@endpush
