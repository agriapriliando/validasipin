<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="copyright" content="MACode ID, https://macodeid.com">
    <title>Validasi PIN IAKNPKY</title>
    <meta name="title" content="Validasi PIN IAKNPKY" />
    <meta name="description" content="Layanan Penerbitan Surat Validasi PIN Calon Lulusan IAKN Palangka Raya. Dikelola Oleh UPT TIPD IAKN Palangka Raya" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Validasi PIN IAKNPKY" />
    <meta property="og:description" content="Layanan Penerbitan Surat Validasi PIN Calon Lulusan IAKN Palangka Raya. Dikelola Oleh UPT TIPD IAKN Palangka Raya" />
    <meta property="og:image" content="https://iaknpky.ac.id/wp-content/uploads/2025/04/iakn_icon.png" />
    <meta property="og:image:width" content="72" />
    <meta property="og:image:height" content="72" />
    <meta property="og:image:type" content="image/png" />

    <!-- X (Twitter) -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="Validasi PIN IAKNPKY" />
    <meta property="twitter:description" content="Layanan Penerbitan Surat Validasi PIN Calon Lulusan IAKN Palangka Raya. Dikelola Oleh UPT TIPD IAKN Palangka Raya" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/animate/animate.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/css/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/css/maicons.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/owl-carousel/css/owl.carousel.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/css/theme.css">
</head>

<body>
    <!-- Back to top button -->
    <div class="back-to-top"></div>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-white shadow-sm">
            <div class="container">
                <a href="{{ url('') }}" class="navbar-brand">Validasi<span class="text-primary">PIN</span></a>

                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse" id="navbarContent">
                    <ul class="navbar-nav ml-lg-4 pt-3 pt-lg-0">
                        <li class="nav-item active">
                            <a href="https://iaknpky.ac.id/upt-tipd-iakn-palangkaraya/" class="nav-link">UPT TIPD</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://pddikti.kemdiktisaintek.go.id/" class="nav-link">PDDikti</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://pisn.kemdiktisaintek.go.id/" class="nav-link">PISN Kemdiktisaintek</a>
                        </li>
                    </ul>

                    <div class="ml-auto">
                        <a href="https://wa.me/6282352127683" class="btn btn-primary rounded-pill">Tanya ?</a>
                    </div>
                </div>
            </div>
        </nav>
        {{ $slot }}
    </header>
    <footer class="page-footer">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-4 py-3">
                    <h3>Validasi<span class="text-primary">PIN</span></h3>
                    <p>UPT Teknologi Informasi dan Pangkalan Data IAKN Palangka Raya</p>
                </div>
                <div class="col-lg-5 py-3">
                    <h5>Quick Links</h5>
                    <ul class="footer-menu">
                        <li><a target="_blank" href="https://iaknpky.ac.id/">IAKNPKY</a></li>
                        <li><a target="_blank" href="https://iaknpky.ac.id/upt-tipd-iakn-palangkaraya/">UPT TIPD IAKNPKY</a></li>
                        <li><a target="_blank" href="https://ecampus.iaknpky.ac.id/">SIMAK IAKNPKY</a></li>
                        <li><a target="_blank" href="https://pddikti.kemdiktisaintek.go.id/">PDDIKTI Kemdiktisaintek</a></li>
                        <li><a target="_blank" href="https://pisn.kemdiktisaintek.go.id/">PISN Kemdiktisaintek</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 py-3">
                    <h5>Media Sosial</h5>
                    <div class="sosmed-button mt-4">
                        <a href="#"><span class="mai-logo-facebook-f"></span></a>
                        <a href="#"><span class="mai-logo-youtube"></span></a>
                        <a href="#"><span class="mai-logo-twitter"></span></a>
                        <a href="#"><span class="mai-logo-google"></span></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 py-2">
                    <p id="copyright">&copy; 2025 <a href="https://iaknpky.ac.id/">UPT TIPD IAKNPKY</a>. All rights reserved</p>
                </div>
                <div class="col-sm-6 py-2 text-right">
                    <div class="d-inline-block px-3">
                        <a href="#">Kebijakan dan Privasi</a>
                    </div>
                    <div class="d-inline-block px-3">
                        <a href="#">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div> <!-- .container -->
    </footer> <!-- .page-footer -->

    <script src="{{ asset('') }}assets/js/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('') }}assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/wow/wow.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/animateNumber/jquery.animateNumber.min.js"></script>
    <script src="{{ asset('') }}assets/js/google-maps.js"></script>
    <script src="{{ asset('') }}assets/js/theme.js"></script>

</body>

</html>
