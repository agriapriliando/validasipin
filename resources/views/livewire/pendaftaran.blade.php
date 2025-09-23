<div class="home-banner">
    <div class="container pb-5">
        @if ($warning['isi'] == 'Aktif')
            <div class="row">
                <style>
                    @keyframes blink-bg-warning {

                        0%,
                        100% {
                            background-color: #fff3cd;
                            color: #856404;
                        }

                        50% {
                            background-color: #856404;
                            color: #fff3cd;
                        }
                    }

                    .alert-blink-warning {
                        animation: blink-bg-warning 1s linear infinite;
                    }
                </style>
                <div class="col">
                    <div x-data="{ show: true }" x-show="show" x-transition class="alert alert-warning alert-blink-warning alert-dismissible fade show" role="alert" style="margin-top:20px;">
                        <strong>Mohon Maaf!</strong> Beberapa ajuan memerlukan waktu yang lebih lama untuk diproses, karena Aplikasi PISN Kemdikti sedang mengalami Gangguan. Terima Kasih.
                        <button type="button" class="btn btn-sm btn-outline-warning" @click="show = false" aria-label="Close"><span class="mai-close"></span></button>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12 wow fadeInUp">
                <!-- Slider main container -->
                <div class="swiper">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <div class="swiper-slide">
                            <a href="{{ asset('assets/01 alur_pin_iaknpky.jpg') }}" target="_blank">
                                <img class="img-fluid" src="{{ asset('assets/01 alur_pin_iaknpky.jpg') }}" alt="">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="{{ asset('assets/02 contoh surat dan berita acara.jpg') }}" target="_blank">
                                <img class="img-fluid" src="{{ asset('assets/02 contoh surat dan berita acara.jpg') }}" alt="">
                            </a>
                        </div>
                    </div>
                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>

                    <!-- If we need scrollbar -->
                    <div class="swiper-scrollbar"></div>
                </div>

            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6 mt-4 wow fadeInUp">
                <h1 class="mb-4">Layanan Validasi PIN</h1>
                <p class="text-lg mb-5">
                    Seluruh Calon Lulusan IAKN Palangka Raya <span class="text-primary font-weight-bold">WAJIB</span> Mengisi Formulir ini sebagai syarat mendapatkan <span
                        style="font-weight: bold">Nomor Ijazah
                        Nasional</span> (NINA)
                </p>

                <a target="_blank" href="https://pisn.kemdiktisaintek.go.id/" class="btn btn-primary btn-split ml-2">Cari Tahu NINA? <div class="fab"><span class="mai-question"></span></div></a>
                <a target="_blank" href="https://wa.me/6282352127683" class="btn btn-outline border text-secondary">Tanya Operator Kampus?</a>
            </div>
            <div class="col-lg-6 mt-4 wow fadeInUp">
                <div class="subhead">Formulir</div>
                <h2 class="title-section">PIN (Penomoran Ijazah Nasional)</h2>
                <div class="divider"></div>
                @if (session()->has('status'))
                    <div class="alert alert-warning">{{ session('status') }}</div>
                @endif
                <form wire:submit.prevent="cekData" enctype="multipart/form-data">
                    <div class="py-2">
                        <input type="text" wire:model.live="nim" class="form-control @error('nim') is-invalid @enderror" placeholder="NIM Contoh : 1223233323">
                        <small class="form-text text-muted">*Masukan NIM Tanpa Menggunakan Titik</small>
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="py-2">
                        <input type="text" wire:model.live="nohp" class="form-control @error('nohp') is-invalid @enderror" placeholder="Contoh 085249999999">
                        <small class="form-text text-muted">*Masukan No HP Whatsapp Aktif</small>
                        @error('nohp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="py-2">
                        <label for="berkas" class="form-label">Upload Berita Acara Ujian Skripsi (PDF / Foto)</label>
                        <input type="file" id="berkas" wire:model="berkas" class="form-control">

                        {{-- Pesan error --}}
                        @error('berkas')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Progress bar upload --}}
                    <div wire:loading wire:target="berkas" class="py-2">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%">
                                Memeriksa Berkas
                            </div>
                        </div>
                    </div>

                    {{-- Preview jika file berupa gambar --}}
                    @if ($berkas && in_array($berkas->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'webp']))
                        <div class="mt-3">
                            <p class="fw-bold">Preview:</p>
                            <img src="{{ $berkas->temporaryUrl() }}" alt="Preview" class="img-fluid rounded" width="200">
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary rounded-pill mt-4" @if ($errors->any()) disabled @endif>SUBMIT</button>
                    <button wire:loading wire:target="cekData" class="btn btn-primary rounded-pill mt-4" @if ($errors->any()) disabled @endif>Tunggu Proses Submit, Kompress
                        Berkas</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('slidercss')
    <style>
        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #444;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide a img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
@endpush

@push('sliderjs')
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script>
        // var swiper = new Swiper(".swiper", {});
        var swiper = new Swiper(".swiper", {
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            preventClicks: true,
            preventClicksPropagation: true,
            // ⏱ pengaturan waktu
            autoplay: {
                delay: 2000, // ganti ke 3000 ms = 3 detik
                disableOnInteraction: false, // biar tetap jalan meskipun user klik/geser
            },
            speed: 600, // durasi transisi geser (ms)
        });
    </script>
@endpush
