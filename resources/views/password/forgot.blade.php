@extends('layouts.umkm')

@section('title', 'Lupa Password - Banjarsugihan UMKM Digital Map')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('umkm.password.change') }}" class="btn btn-outline-secondary">
                    <i class="ri-arrow-left-line me-2"></i>
                    Kembali
                </a>
            </div>

            <!-- Forgot Password Card -->
            <div class="card">
                <div class="card-body text-center py-5">
                    <!-- Icon -->
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning-subtle"
                             style="width: 80px; height: 80px;">
                            <i class="ri-lock-password-line display-4 text-warning"></i>
                        </div>
                    </div>

                    <!-- Title -->
                    <h4 class="mb-3">Lupa Password?</h4>

                    <!-- Description -->
                    <p class="text-muted mb-4">
                        Jangan khawatir, kami siap membantu Anda untuk reset password akun UMKM.
                    </p>

                    <!-- Instructions -->
                    <div class="alert alert-info text-start mb-4">
                        <div class="d-flex align-items-start">
                            <i class="ri-information-line me-2 mt-1"></i>
                            <div>
                                <h6 class="mb-2">Cara Reset Password:</h6>
                                <ol class="mb-0 ps-3">
                                    <li>Hubungi Admin melalui kontak yang tersedia</li>
                                    <li>Berikan informasi UMKM dan username Anda</li>
                                    <li>Admin akan memverifikasi identitas Anda</li>
                                    <li>Password baru akan dikirim atau dibuat ulang</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="card border bg-light h-100">
                                <div class="card-body text-center p-3">
                                    <i class="ri-phone-line text-primary mb-2" style="font-size: 1.5rem;"></i>
                                    <h6 class="mb-1">WhatsApp</h6>
                                    <a href="https://wa.me/6281234567890"
                                       target="_blank"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="ri-whatsapp-line me-1"></i>
                                        Hubungi
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card border bg-light h-100">
                                <div class="card-body text-center p-3">
                                    <i class="ri-mail-line text-success mb-2" style="font-size: 1.5rem;"></i>
                                    <h6 class="mb-1">Email</h6>
                                    <a href="mailto:admin@banjarsugihan.com"
                                       class="btn btn-outline-success btn-sm">
                                        <i class="ri-mail-line me-1"></i>
                                        Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="alert alert-warning text-start">
                        <div class="d-flex align-items-start">
                            <i class="ri-shield-check-line me-2 mt-1"></i>
                            <div>
                                <h6 class="mb-2">Keamanan Akun</h6>
                                <small class="text-muted">
                                    Untuk keamanan, admin akan memverifikasi identitas Anda sebelum melakukan reset password.
                                    Pastikan Anda menghubungi admin melalui kontak resmi yang tertera di atas.
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Back to Login -->
                    <div class="mt-4 pt-3 border-top">
                        <p class="text-muted mb-0">
                            Sudah ingat password?
                            <a href="{{ route('login') }}" class="text-primary">
                                <i class="ri-login-circle-line me-1"></i>
                                Kembali ke Login
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="ri-question-line me-2"></i>
                        Pertanyaan Umum
                    </h6>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Berapa lama proses reset password?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <small class="text-muted">
                                        Proses reset password biasanya memakan waktu 1-2 hari kerja setelah admin memverifikasi identitas Anda.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Informasi apa yang diperlukan untuk reset password?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <small class="text-muted">
                                        Anda perlu memberikan nama UMKM, username, dan nomor telepon yang terdaftar untuk verifikasi identitas.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Apakah layanan reset password gratis?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <small class="text-muted">
                                        Ya, layanan reset password adalah gratis untuk semua pengguna UMKM yang terdaftar.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
