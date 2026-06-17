<footer class="py-5 mt-5" style="background-color: #1A4D2E; color: #FFFFFF;">
    <div class="container">
        <div class="row g-4">
            <!-- Kontak -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3" style="color: #C5E384;">CONTACT US</h5>
                <p class="small mb-1">Institut Teknologi Del</p>
                <p class="small mb-1">Jl. Sisingamangaraja, Desa Sitoluama,</p>
                <p class="small mb-1">Kecamatan Laguboti, Kabupaten Toba</p>
                <p class="small mb-1">Provinsi Sumatera Utara, Indonesia</p>
                <p class="small mb-1">Kode Pos: 22381</p>
                <p class="small mb-1">Telp: +62 632 331234</p>
                <p class="small mb-1">Fax: +62 632 331116</p>
                <p class="small mb-1">Website: https://www.del.ac.id</p>
                <p class="small mb-0">Email: info@del.ac.id</p>
            </div>

            <!-- Social Media -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3" style="color: #C5E384;">FIND US ON</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="https://web.facebook.com/Institut.Technology.Del/" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none transition-hover">
                            <i class="bi bi-facebook me-2"></i> Facebook
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="https://twitter.com/institut_del" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none transition-hover">
                            <i class="bi bi-twitter me-2"></i> Twitter
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="https://www.youtube.com/@institutteknologidel1337" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none transition-hover">
                            <i class="bi bi-youtube me-2"></i> Youtube
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="https://www.instagram.com/bp.itdel/" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none transition-hover">
                            <i class="bi bi-instagram me-2"></i> Instagram
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Akses Cepat & Search -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3" style="color: #C5E384;">AKSES CEPAT</h5>
                <ul class="list-unstyled">
                    <li class="mb-1"><a href="/" class="text-warning text-decoration-none transition-hover">Home</a></li>
                    <li class="mb-1"><a href="https://cis.del.ac.id/user/login" target="_blank" class="text-warning text-decoration-none transition-hover">Campus Information System</a></li>
                    <li class="mb-1"><a href="https://ecourse.del.ac.id/login/index.php" target="_blank" class="text-warning text-decoration-none transition-hover">E-Course Learning Management System</a></li>
                    <li class="mb-1"><a href="#" target="_blank" class="text-warning text-decoration-none transition-hover">Online Library Information System</a></li>
                </ul>
            </div>
        </div>

        <hr class="mt-4 border-light opacity-25">

        <div class="row align-items-center g-3">
            <div class="col-md-6 text-center text-md-start">
                <p class="small mb-0">Copyright © {{ date('Y') }} Kelompok PA 1 - Teknologi Informasi, Institut Teknologi Del. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <img src="{{ asset('guest_assets/img/logo-del.png') }}" alt="Logo IT Del" class="img-fluid me-2" style="height: 40px;">
                <img src="{{ asset('guest_assets/img/yayasan-del.png') }}" alt="Logo Yayasan Del" class="img-fluid" style="height: 40px;">
            </div>
        </div>
    </div>
</footer>

<style>
    .transition-hover {
        transition: all 0.2s ease;
    }
    .transition-hover:hover {
        color: #C5E384 !important;
        padding-left: 4px;
    }
    @media (max-width: 768px) {
        footer .col-md-6.text-md-end {
            margin-top: 0.5rem;
        }
        footer .col-md-6 img {
            height: 32px;
        }
    }
</style>