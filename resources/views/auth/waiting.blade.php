<p>tunggu</p>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-sm btn-danger d-flex w-100">
        <small class="align-middle">Logout</small>
        <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
    </button>
</form>
