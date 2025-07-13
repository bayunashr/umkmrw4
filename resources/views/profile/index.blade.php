@extends('layouts.umkm')

@section('title', $umkm->name . ' - Banjarsugihan UMKM Digital Map')

@section('content')
    <div class="row">
        <!-- Alert Messages -->
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
                    <i class="ri-checkbox-circle-line me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center alert-dismissible" role="alert">
                    <i class="ri-error-warning-line me-2"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->has('cover'))
                <div class="alert alert-danger d-flex align-items-center alert-dismissible" role="alert">
                    <i class="ri-error-warning-line me-2"></i>
                    <div>{{ $errors->first('cover') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->has('logo'))
                <div class="alert alert-danger d-flex align-items-center alert-dismissible" role="alert">
                    <i class="ri-error-warning-line me-2"></i>
                    <div>{{ $errors->first('logo') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Profile Completion Alert -->
            @php
                $nullableFields = [
                    'Deskripsi' => $umkm->description,
                    'Alamat' => $umkm->address,
                    'RT' => $umkm->rt,
                    'RW' => $umkm->rw,
                    'Logo' => $umkm->logo_path,
                    'Cover' => $umkm->cover_path,
                ];
                $missing = collect($nullableFields)
                            ->filter(fn($val) => is_null($val) || empty($val))
                            ->keys()
                            ->map(fn($key) => ucwords(str_replace('_', ' ', $key)));
                $completionPercentage = round(((count($nullableFields) - $missing->count()) / count($nullableFields)) * 100);
            @endphp

            @if ($missing->isNotEmpty())
                <div class="card border-start border-warning border-4 bg-light mb-4" style="border-top: none; border-right: none; border-bottom: none;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <i class="ri-bar-chart-line text-warning me-2"></i>
                                <h6 class="mb-0 text-body">Kelengkapan Profil</h6>
                            </div>
                            <span class="badge bg-warning-subtle text-warning fw-medium">{{ $completionPercentage }}%</span>
                        </div>

                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-warning"
                                 role="progressbar" style="width: {{ $completionPercentage }}%;"
                                 aria-valuenow="{{ $completionPercentage }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>

                        <p class="text-muted mb-3 small">
                            Lengkapi data berikut untuk meningkatkan visibilitas UMKM:
                        </p>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach ($missing as $item)
                                <span class="badge bg-warning-subtle text-warning border">
                                    {{ $item }}
                                </span>
                            @endforeach
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <small class="text-muted">
                                <i class="ri-information-line me-1"></i>
                                Profil lengkap meningkatkan kepercayaan pelanggan
                            </small>
                            <a href="{{ route('umkm.profile.edit', $umkm->slug) }}"
                               class="btn btn-warning btn-sm">
                                <i class="ri-edit-line me-1"></i>
                                Lengkapi
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="card border-start border-success border-4 bg-light mb-4" style="border-top: none; border-right: none; border-bottom: none;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <i class="ri-check-double-line text-primary me-2"></i>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 text-body">Profil Lengkap</h6>
                                <small class="text-muted">Semua informasi profil sudah terisi dengan baik</small>
                            </div>
                            <span class="badge bg-primary-subtle text-primary">100%</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-0 order-md-0">
            <div class="card mb-6">
                <div class="card-body pt-4">
                    <!-- Logo Section -->
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column position-relative">
                            <!-- Logo Menu Dropdown -->
                            <div class="position-absolute top-0 end-0" style="z-index: 10;">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary rounded-pill" type="button"
                                            id="logoMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-2-line"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="logoMenu">
                                        @if ($umkm->logo_path)
                                            <li>
                                                <h6 class="dropdown-header">Kelola Logo</h6>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('umkm.logo.update') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <label class="dropdown-item d-flex align-items-center" style="cursor: pointer;">
                                                        <i class="ri-image-edit-line me-2"></i>
                                                        Ganti Logo
                                                        <input type="file" name="logo" accept="image/*" onchange="this.form.submit()" hidden>
                                                    </label>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action="{{ route('umkm.logo.destroy') }}"
                                                      onsubmit="return confirm('Yakin ingin menghapus logo?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                                        <i class="ri-delete-bin-line me-2"></i>
                                                        Hapus Logo
                                                    </button>
                                                </form>
                                            </li>
                                        @else
                                            <li>
                                                <h6 class="dropdown-header">Logo UMKM</h6>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('umkm.logo.store') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <label class="dropdown-item d-flex align-items-center" style="cursor: pointer;">
                                                        <i class="ri-image-add-line me-2"></i>
                                                        Tambah Logo
                                                        <input type="file" name="logo" accept="image/*" onchange="this.form.submit()" hidden>
                                                    </label>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <!-- Logo Display -->
                            <div class="logo-container mb-4">
                                @if ($umkm->logo_path && file_exists(public_path('storage/' . $umkm->logo_path)))
                                    <img class="img-fluid rounded-3 shadow-sm"
                                         src="{{ asset('storage/' . $umkm->logo_path) }}"
                                         height="120" width="120" alt="Logo {{ $umkm->name }}"
                                         style="object-fit: cover; width: 120px; height: 120px;" />
                                @else
                                    @php
                                        $initials = collect(explode(' ', $umkm->name))
                                            ->filter()
                                            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                            ->take(3)
                                            ->join('');
                                        $colors = ['primary', 'success', 'info', 'warning', 'danger'];
                                        $color = $colors[abs(crc32($umkm->name)) % count($colors)];
                                    @endphp
                                    <div class="d-flex align-items-center justify-content-center bg-label-{{ $color }} shadow-sm"
                                         style="width: 120px; height: 120px; font-size: 2.5rem; border-radius: 0.75rem; font-weight: 600;">
                                        {{ $initials }}
                                    </div>
                                @endif
                            </div>

                            <!-- UMKM Name & Status -->
                            <div class="user-info text-center">
                                <h4 class="mb-2">{{ $umkm->name }}</h4>
                                <span class="badge bg-primary mb-3">
                                    <i class="ri-verified-badge-line me-1"></i>
                                    Terverifikasi
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="d-flex justify-content-around my-4 py-3 bg-light rounded-3">
                        <div class="d-flex flex-column align-items-center">
                            <div class="avatar avatar-sm mb-2">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <i class="ri-cake-3-line"></i>
                                </div>
                            </div>
                            <h5 class="mb-0">{{ $productCount }}</h5>
                            <small class="text-muted">Produk</small>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <div class="avatar avatar-sm mb-2">
                                <div class="avatar-initial bg-label-info rounded-3">
                                    <i class="ri-gallery-line"></i>
                                </div>
                            </div>
                            <h5 class="mb-0">{{ $galleryCount }}</h5>
                            <small class="text-muted">Galeri</small>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <div class="avatar avatar-sm mb-2">
                                <div class="avatar-initial bg-label-success rounded-3">
                                    <i class="ri-share-line"></i>
                                </div>
                            </div>
                            <h5 class="mb-0">{{ $umkm->socialMedia->count() }}</h5>
                            <small class="text-muted">Sosmed</small>
                        </div>
                    </div>

                    <!-- Detail Information -->
                    <div class="info-container">
                        <h6 class="pb-3 border-bottom mb-4 text-muted text-uppercase fw-medium">Detail UMKM</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="ri-user-line me-3 mt-1 text-muted"></i>
                                <div>
                                    <span class="fw-medium text-heading d-block">Pemilik</span>
                                    <span class="text-muted">{{ $umkm->user->name }}</span>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="ri-at-line me-3 mt-1 text-muted"></i>
                                <div>
                                    <span class="fw-medium text-heading d-block">Username</span>
                                    <span class="text-muted">{{ $umkm->user->username }}</span>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="ri-phone-line me-3 mt-1 text-muted"></i>
                                <div>
                                    <span class="fw-medium text-heading d-block">Telepon</span>
                                    <a href="tel:{{ $umkm->phone }}" class="text-muted">{{ $umkm->phone ?? 'Belum diisi' }}</a>
                                </div>
                            </li>
                            @if($umkm->description)
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="ri-file-text-line me-3 mt-1 text-muted"></i>
                                    <div>
                                        <span class="fw-medium text-heading d-block">Deskripsi</span>
                                        <span class="text-muted">{{ Str::limit($umkm->description, 100) }}</span>
                                    </div>
                                </li>
                            @endif
                            @if($umkm->address)
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="ri-map-pin-line me-3 mt-1 text-muted"></i>
                                    <div>
                                        <span class="fw-medium text-heading d-block">Alamat</span>
                                        <span class="text-muted">{{ $umkm->address }}</span>
                                        @if($umkm->rt || $umkm->rw)
                                            <br><small class="text-muted">RT {{ $umkm->rt ?? '-' }}/RW {{ $umkm->rw ?? '-' }}</small>
                                        @endif
                                    </div>
                                </li>
                            @endif
                        </ul>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('umkm.profile.edit', $umkm->slug) }}"
                               class="btn btn-primary d-flex align-items-center justify-content-center">
                                <i class="ri-edit-line me-2"></i>
                                Perbarui Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Password Management Section -->
            <div class="card mb-6">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="ri-shield-keyhole-line me-2"></i>
                        <h5 class="mb-0">Keamanan Akun</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="mb-2">Password</h6>
                            <p class="text-muted mb-3">
                                Jaga keamanan akun Anda dengan menggunakan password yang kuat dan unik.
                                Password terakhir diubah pada:
                                <span class="fw-medium">
                                    {{ $umkm->user->updated_at ? $umkm->user->updated_at->format('d M Y H:i') : 'Belum pernah diubah' }}
                                </span>
                            </p>

                            <!-- Password Strength Info -->
                            <div class="alert alert-danger d-flex align-items-start">
                                <i class="ri-information-line me-2 mt-1"></i>
                                <div>
                                    <small class="mb-2 d-block fw-medium">Tips Password Mudah Diingat:</small>
                                    <ul class="mb-0 small text-muted ps-3">
                                        <li>Minimal 6 karakter</li>
                                        <li>Boleh menggunakan nama + angka (contoh: sari123)</li>
                                        <li>Bisa nama UMKM + tahun (contoh: toko2024)</li>
                                        <li>Jangan gunakan password yang sama untuk akun lain</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <!-- Change Password Button -->
                                <a href="{{ route('umkm.password.change') }}"
                                   class="btn btn-danger d-flex align-items-center justify-content-center">
                                    <i class="ri-lock-password-line me-2"></i>
                                    Ganti Password
                                </a>

                                <!-- Forgot Password Button -->
                                <a href="{{ route('umkm.password.forgot') }}"
                                   class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                    <i class="ri-question-line me-2"></i>
                                    Lupa Password?
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-1 order-md-1">
            <!-- Cover Image Section -->
            <div class="card mb-6">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="ri-image-line me-2"></i>
                        <h5 class="mb-0">Cover UMKM</h5>
                    </div>
                    <!-- Cover Menu Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary rounded-pill" type="button"
                                id="coverMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-line"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="coverMenu">
                            @if ($umkm->cover_path)
                                <li>
                                    <h6 class="dropdown-header">Kelola Cover</h6>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('umkm.cover.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <label class="dropdown-item d-flex align-items-center" style="cursor: pointer;">
                                            <i class="ri-image-edit-line me-2"></i>
                                            Ganti Cover
                                            <input type="file" name="cover" accept="image/*" onchange="this.form.submit()" hidden>
                                        </label>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('umkm.cover.destroy') }}"
                                          onsubmit="return confirm('Yakin ingin menghapus cover?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger d-flex align-items-center">
                                            <i class="ri-delete-bin-line me-2"></i>
                                            Hapus Cover
                                        </button>
                                    </form>
                                </li>
                            @else
                                <li>
                                    <h6 class="dropdown-header">Cover UMKM</h6>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('umkm.cover.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <label class="dropdown-item d-flex align-items-center" style="cursor: pointer;">
                                            <i class="ri-image-add-line me-2"></i>
                                            Tambah Cover
                                            <input type="file" name="cover" accept="image/*" onchange="this.form.submit()" hidden>
                                        </label>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($umkm->cover_path && file_exists(public_path('storage/' . $umkm->cover_path)))
                        <div class="cover-image-container position-relative">
                            <img src="{{ asset('storage/' . $umkm->cover_path) }}"
                                 alt="Cover {{ $umkm->name }}"
                                 class="img-fluid w-100 cover-image"
                                 style="height: 300px; object-fit: cover;">

                            <!-- Overlay with UMKM name -->
                            <div class="cover-overlay position-absolute bottom-0 start-0 end-0 p-4">
                                <div class="d-flex align-items-end justify-content-between">
                                    <div>
                                        <h4 class="text-white mb-1 fw-bold">{{ $umkm->name }}</h4>
                                        @if($umkm->address)
                                            <p class="text-white-50 mb-0">
                                                <i class="ri-map-pin-line me-1"></i>
                                                {{ Str::limit($umkm->address, 50) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="cover-placeholder d-flex align-items-center justify-content-center text-center py-5"
                             style="height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div class="text-white">
                                <i class="ri-image-line display-1 mb-3 opacity-75"></i>
                                <h5 class="text-white mb-2">Belum ada cover</h5>
                                <p class="text-white-50 mb-3">Tambahkan gambar cover untuk mempercantik profil UMKM Anda</p>
                                <form method="POST" action="{{ route('umkm.cover.store') }}" enctype="multipart/form-data" class="d-inline">
                                    @csrf
                                    <label class="btn btn-light btn-sm d-inline-flex align-items-center" style="cursor: pointer;">
                                        <i class="ri-image-add-line me-2"></i>
                                        Tambah Cover
                                        <input type="file" name="cover" accept="image/*" onchange="this.form.submit()" hidden>
                                    </label>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Map Section -->
            <div class="card mb-6">
                <div class="card-header d-flex align-items-center">
                    <i class="ri-map-pin-line me-2"></i>
                    <h5 class="mb-0">Lokasi UMKM</h5>
                </div>
                <div class="card-body">
                    @if($umkm->latitude && $umkm->longitude)
                        <div id="map" style="height: 400px; border-radius: 0.75rem; overflow: hidden;" class="shadow-sm"></div>
                        <div class="mt-3 p-3 bg-light rounded-3">
                            <div class="row text-center">
                                <div class="col-6">
                                    <small class="text-muted d-block">Latitude</small>
                                    <span class="fw-medium">{{ $umkm->latitude }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Longitude</small>
                                    <span class="fw-medium">{{ $umkm->longitude }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ri-map-pin-line display-4 text-muted mb-3"></i>
                            <h6 class="text-muted">Lokasi belum ditentukan</h6>
                            <p class="text-muted">Silakan perbarui profil untuk menambahkan lokasi UMKM</p>
                            <a href="{{ route('umkm.profile.edit', $umkm->slug) }}" class="btn btn-outline-primary">
                                <i class="ri-edit-line me-1"></i>
                                Update Lokasi
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="ri-share-line me-2"></i>
                        <h5 class="mb-0">Sosial Media</h5>
                    </div>
                    <span class="badge bg-label-primary">{{ $umkm->socialMedia->count() }} Platform</span>
                </div>
                <div class="card-body">
                    @if ($umkm->socialMedia->count() > 0)
                        <div class="row g-3">
                            @foreach ($umkm->socialMedia as $social)
                                @php
                                    $platformConfig = [
                                        'facebook' => ['icon' => 'ri-facebook-fill', 'color' => '#1877F2', 'name' => 'Facebook'],
                                        'instagram' => ['icon' => 'ri-instagram-fill', 'color' => '#E4405F', 'name' => 'Instagram'],
                                        'twitter' => ['icon' => 'ri-twitter-x-fill', 'color' => '#000000', 'name' => 'Twitter/X'],
                                        'tiktok' => ['icon' => 'ri-tiktok-fill', 'color' => '#000000', 'name' => 'TikTok'],
                                        'whatsapp' => ['icon' => 'ri-whatsapp-fill', 'color' => '#25D366', 'name' => 'WhatsApp'],
                                        'youtube' => ['icon' => 'ri-youtube-fill', 'color' => '#FF0000', 'name' => 'YouTube'],
                                        'linkedin' => ['icon' => 'ri-linkedin-fill', 'color' => '#0077B5', 'name' => 'LinkedIn']
                                    ];
                                    $config = $platformConfig[$social->platform] ?? ['icon' => 'ri-link', 'color' => '#6c757d', 'name' => ucfirst($social->platform)];
                                @endphp
                                <div class="col-md-6 mb-3">
                                    <div class="card border h-100 social-media-card">
                                        <div class="card-body d-flex align-items-center p-3">
                                            <div class="avatar avatar-sm me-3 flex-shrink-0">
                                                <div class="avatar-initial rounded-3" style="background-color: {{ $config['color'] }}15;">
                                                    <i class="{{ $config['icon'] }}" style="color: {{ $config['color'] }};"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 me-2 min-w-0">
                                                <h6 class="mb-1 text-truncate">{{ $config['name'] }}</h6>
                                                <small class="text-muted text-truncate d-block social-url">{{ $social->url }}</small>
                                            </div>
                                            <div class="social-action">
                                                <a href="{{ $social->url }}" target="_blank"
                                                   class="btn btn-sm btn-outline-secondary rounded-pill d-flex align-items-center"
                                                   data-bs-toggle="tooltip" title="Buka {{ $config['name'] }}">
                                                    <i class="ri-external-link-line"></i>
                                                    <span class="d-none d-sm-inline ms-1">Buka</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ri-share-line display-4 text-muted mb-3"></i>
                            <h6 class="text-muted">Belum ada sosial media</h6>
                            <p class="text-muted">Tambahkan link sosial media untuk mempromosikan UMKM Anda</p>
                            <a href="{{ route('umkm.profile.edit', $umkm->slug) }}" class="btn btn-outline-primary">
                                <i class="ri-add-line me-1"></i>
                                Tambah Sosial Media
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}" />
    <style>
        .hover-shadow-sm {
            transition: box-shadow 0.2s ease-in-out;
        }
        .hover-shadow-sm:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
        }
        .logo-container {
            position: relative;
        }
        .leaflet-popup-content-wrapper {
            border-radius: 0.75rem;
        }
        .leaflet-control-zoom a {
            border-radius: 0.375rem;
        }

        /* Social Media Card Responsive */
        .social-media-card {
            transition: all 0.2s ease-in-out;
        }
        .social-media-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .social-url {
            max-width: 200px;
        }

        /* Mobile responsive fixes for social media cards */
        @media (max-width: 576px) {
            .social-media-card .card-body {
                padding: 0.75rem !important;
            }

            .social-action {
                flex-shrink: 0;
                min-width: 60px;
            }

            .social-url {
                max-width: 120px;
            }

            .avatar-sm {
                width: 1.75rem;
                height: 1.75rem;
            }
        }

        @media (max-width: 768px) {
            .social-url {
                max-width: 150px;
            }
        }

        /* Profile completion card enhancements */
        .border-start {
            border-left-width: 4px !important;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .text-success {
            color: #198754 !important;
        }

        .border-warning {
            border-color: #ffc107 !important;
        }

        .border-success {
            border-color: #198754 !important;
        }

        .min-w-0 {
            min-width: 0;
        }

        /* Cover Image Styles */
        .cover-image-container {
            overflow: hidden;
        }

        .cover-image {
            transition: transform 0.3s ease;
        }

        .cover-image:hover {
            transform: scale(1.05);
        }

        .cover-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, transparent 100%);
            backdrop-filter: blur(1px);
        }

        .cover-placeholder {
            position: relative;
            overflow: hidden;
        }

        .cover-placeholder::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="10" cy="50" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="90" cy="30" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .backdrop-blur {
            backdrop-filter: blur(4px);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .cover-image {
                height: 200px !important;
            }

            .cover-placeholder {
                height: 200px !important;
            }

            .cover-overlay {
                padding: 1rem !important;
            }

            .cover-overlay h4 {
                font-size: 1.25rem !important;
            }
        }

        @media (max-width: 576px) {
            .cover-overlay h4 {
                font-size: 1.1rem !important;
            }

            .cover-overlay p {
                font-size: 0.875rem !important;
            }
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize map only if coordinates exist
            @if($umkm->latitude && $umkm->longitude)
            const lat = {{ $umkm->latitude }};
            const lng = {{ $umkm->longitude }};

            const map = L.map('map', {
                zoomControl: true,
                scrollWheelZoom: false
            }).setView([lat, lng], 18);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(map);

            // Custom marker icon
            const customIcon = L.divIcon({
                html: '<div style="background-color: #007bff; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"></div>',
                className: 'custom-marker',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });

            const marker = L.marker([lat, lng], {
                icon: customIcon,
                draggable: false
            })
                .addTo(map)
                .bindPopup(`
                    <div class="text-center">
                        <strong>{{ $umkm->name }}</strong><br>
                        <small class="text-muted">{{ $umkm->address ?? 'Lokasi UMKM' }}</small>
                    </div>
                `, {
                    className: 'custom-popup'
                })
                .openPopup();

            // Add click handler to enable zoom on click
            map.on('click', function() {
                map.scrollWheelZoom.enable();
            });

            map.on('mouseout', function() {
                map.scrollWheelZoom.disable();
            });
            @endif
        });
    </script>
@endpush
