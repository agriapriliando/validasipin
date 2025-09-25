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
                        <div class="swiper-slide">
                            <a href="{{ asset('assets/02 contoh surat dan berita acara.jpg') }}" target="_blank">
                                <img class="img-fluid" src="{{ asset('assets/03 Pengumuman PISN.jpg') }}" alt="">
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
        <style>
            .btn-anim {
                position: relative;
                border: 2px solid transparent;
                overflow: hidden;
            }

            .btn-anim::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 200%;
                height: 200%;
                background: linear-gradient(90deg, transparent, red, transparent);
                animation: move-border 3s linear infinite;
            }

            @keyframes move-border {
                0% {
                    transform: translateX(-100%) translateY(-100%);
                }

                50% {
                    transform: translateX(0%) translateY(0%);
                }

                100% {
                    transform: translateX(100%) translateY(100%);
                }
            }
        </style>
        <div class="row my-3">
            <div class="col-12 wow fadeInUp">
                <p class="text-center">Jika ada kesalahan atau perbaikan silahkan mengisi Formulir Ini | Seluruh data ditarik langsung via API PDDikti, sehingga untuk melakukan perubahan harus
                    mengajukan ke Pokja
                    PDDikti Pusat diperlukan waktu maksimal 3
                    bulan.</p>
                <a class="btn btn-primary btn-block btn-anim" href="https://iaknpky.ac.id/upt-tipd-iakn-palangkaraya/" target="_blank">Formulir Perubahan Data PDDikti</a>
                @session('suraterror')
                    <div class="alert alert-danger" role="alert">
                        {{ session('suraterror') }}
                    </div>
                @endsession
            </div>
        </div>
        <div class="row align-items-center mb-3">
            <div class="col-lg-6 mt-4 wow fadeInUp">
                <h1 class="mb-4">Layanan Validasi PIN</h1>
                <p class="text-lg mb-2">
                    Seluruh Mahasiswa (S1, S2, S3) IAKN Palangka Raya yang telah mengikuti Ujian (Skripsi/Tesis/Disertasi) <span class="text-primary font-weight-bold">WAJIB</span> Mengisi Formulir PIN
                    sebagai syarat mendapatkan <span class="text-primary font-weight-bold">Nomor Ijazah Nasional (NINA)</span>
                </p>

                <a target="_blank" href="https://pisn.kemdiktisaintek.go.id/" class="btn btn-primary btn-split mt-2">Cari Tahu NINA? <div class="fab"><span class="mai-question"></span></div></a>
                <a target="_blank" href="https://wa.me/6282352127683" class="btn btn-outline border text-secondary mt-2">Tanya Operator Kampus?</a>
                <a href="#chart" class="btn btn-outline border text-secondary mt-2">Lihat Grafik</a>
                <a class="btn btn-primary mt-2 btn-anim" href="https://iaknpky.ac.id/upt-tipd-iakn-palangkaraya/" target="_blank">Formulir Perubahan Data PDDikti</a>
            </div>
            <div class="col-lg-6 mt-4 wow fadeInUp">
                <div class="subhead">Formulir</div>
                <h2 class="title-section">PIN (Penomoran Ijazah Nasional)</h2>
                <div class="divider"></div>
                @if (session()->has('status'))
                    <div class="alert alert-warning">{{ session('status') }}</div>
                @endif
                <form wire:submit.prevent="cekData" enctype="multipart/form-data" x-data="{ progress: 0 }" x-on:livewire-upload-start="progress = 0" x-on:livewire-upload-finish="progress = 0"
                    x-on:livewire-upload-error="progress = 0" x-on:livewire-upload-progress="progress = $event.detail.progress">

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
                        <label for="berkas" class="form-label text-muted">Upload Berita Acara Ujian (PDF / Foto)</label>
                        <input type="file" id="berkas" wire:model="berkas" class="form-control">
                        <small class="form-text text-muted">Skripsi/ Tesis/ Disertasi | Hanya Halaman Depan, yang mencantumkan tanggal dan nilai</small>
                        <a class="m-0 p-0 text-muted" style="font-size: 14px" href="{{ asset('assets/02 contoh surat dan berita acara.jpg') }}" target="_blank">Lihat Contoh Berita Acara</a>
                        @error('berkas')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Progress bar upload --}}
                    <div class="py-2" x-show="progress > 0">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style="'width: ' + progress + '%'">
                                <span x-text="progress + '%'"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill" :disabled="progress > 0 || {{ $errors->any() ? 'true' : 'false' }}">
                        S U B M I T
                    </button>
                    <button wire:loading wire:target="cekData" class="btn btn-primary rounded-pill" @if ($errors->any()) disabled @endif>
                        Tunggu Proses Submit, Kompress Berkas
                    </button>
                </form>
            </div>
            <div class="col-12">
                <div x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" type="button" class="btn btn-primary mt-2 btn-anim btn-block"><i class="mai-search"></i> Cek NIM Anda</button>
                    <div x-show="open" x-transition class="input-group mt-3">
                        <input type="text" class="form-control" placeholder="NIM Contoh : 1223233323" wire:model.live.debounce.700ms="cek_nim">
                        @if ($this->link_surat)
                            <div class="input-group-append">
                                <a href="{{ $this->link_surat }}" target="_blank" class="btn btn-primary"><span class="mai-eye"></span> Lihat Surat</a>
                            </div>
                        @else
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">{{ $cek_nim ? 'Tidak Ditemukan' : '-----' }}</button>
                            </div>
                        @endif
                        <!-- Loading indicator saat cek_nim diketik -->
                    </div>
                    @if ($this->link_surat)
                        <small x-show="open" class="badge badge-success">Surat Ditemukan</small>
                        <small x-show="open" class="badge badge-success">NIM Anda : {{ $status_eligible == 'Eligible' ? 'Eligible' : 'Sedang divalidasi oleh Admin' }}</small><br>
                    @else
                        @if ($cek_nim != '')
                            <small x-show="open" class="badge badge-danger">NIM dan Surat Tidak Ditemukan, Silahkan Isi Formulir PIN di Atas</small><br>
                        @endif
                    @endif
                    <small x-show="open" class="text-muted">*Masukan NIM Tanpa Menggunakan Titik</small>
                    <div wire:loading wire:target="cek_nim" class="mt-2 text-primary">
                        Sedang mencari Surat Berdasarkan NIM
                    </div>
                </div>
            </div>
        </div>
        <hr id="chart">
        <div class="row">
            <div class="col-12 wow fadeInUp">
                <div id="charthome"></div>
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

@push('chartjs')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <!-- optional -->
    <script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil tanggal hari ini
            let today = new Date();
            let options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            let formattedDate = today.toLocaleDateString('id-ID', options);

            Highcharts.chart('charthome', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Jumlah Isian Form Berdasarkan Program Studi'
                },
                subtitle: {
                    text: 'Data ini Berdasarkan Mahasiswa yang telah mengisi Formulir PIN (per ' + formattedDate + ')'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category',
                    title: {
                        text: 'Prodi'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Mahasiswa'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.f} Orang'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: ' +
                        '<b>{point.y:.f} Orang'
                },

                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: @json($seriesData) // kirim data dari Livewire ke JS
                }],
                // drilldown: {
                //     breadcrumbs: {
                //         position: {
                //             align: 'right'
                //         }
                //     },
                //     series: [{
                //             name: 'Chrome',
                //             id: 'Chrome',
                //             data: [
                //                 [
                //                     'v65.0',
                //                     0.1
                //                 ],
                //                 [
                //                     'v64.0',
                //                     1.3
                //                 ],
                //                 [
                //                     'v63.0',
                //                     53.02
                //                 ],
                //                 [
                //                     'v62.0',
                //                     1.4
                //                 ],
                //                 [
                //                     'v61.0',
                //                     0.88
                //                 ],
                //                 [
                //                     'v60.0',
                //                     0.56
                //                 ],
                //                 [
                //                     'v59.0',
                //                     0.45
                //                 ],
                //                 [
                //                     'v58.0',
                //                     0.49
                //                 ],
                //                 [
                //                     'v57.0',
                //                     0.32
                //                 ],
                //                 [
                //                     'v56.0',
                //                     0.29
                //                 ],
                //                 [
                //                     'v55.0',
                //                     0.79
                //                 ],
                //                 [
                //                     'v54.0',
                //                     0.18
                //                 ],
                //                 [
                //                     'v51.0',
                //                     0.13
                //                 ],
                //                 [
                //                     'v49.0',
                //                     2.16
                //                 ],
                //                 [
                //                     'v48.0',
                //                     0.13
                //                 ],
                //                 [
                //                     'v47.0',
                //                     0.11
                //                 ],
                //                 [
                //                     'v43.0',
                //                     0.17
                //                 ],
                //                 [
                //                     'v29.0',
                //                     0.26
                //                 ]
                //             ]
                //         },
                //         {
                //             name: 'Firefox',
                //             id: 'Firefox',
                //             data: [
                //                 [
                //                     'v58.0',
                //                     1.02
                //                 ],
                //                 [
                //                     'v57.0',
                //                     7.36
                //                 ],
                //                 [
                //                     'v56.0',
                //                     0.35
                //                 ],
                //                 [
                //                     'v55.0',
                //                     0.11
                //                 ],
                //                 [
                //                     'v54.0',
                //                     0.1
                //                 ],
                //                 [
                //                     'v52.0',
                //                     0.95
                //                 ],
                //                 [
                //                     'v51.0',
                //                     0.15
                //                 ],
                //                 [
                //                     'v50.0',
                //                     0.1
                //                 ],
                //                 [
                //                     'v48.0',
                //                     0.31
                //                 ],
                //                 [
                //                     'v47.0',
                //                     0.12
                //                 ]
                //             ]
                //         },
                //         {
                //             name: 'Internet Explorer',
                //             id: 'Internet Explorer',
                //             data: [
                //                 [
                //                     'v11.0',
                //                     6.2
                //                 ],
                //                 [
                //                     'v10.0',
                //                     0.29
                //                 ],
                //                 [
                //                     'v9.0',
                //                     0.27
                //                 ],
                //                 [
                //                     'v8.0',
                //                     0.47
                //                 ]
                //             ]
                //         },
                //         {
                //             name: 'Safari',
                //             id: 'Safari',
                //             data: [
                //                 [
                //                     'v11.0',
                //                     3.39
                //                 ],
                //                 [
                //                     'v10.1',
                //                     0.96
                //                 ],
                //                 [
                //                     'v10.0',
                //                     0.36
                //                 ],
                //                 [
                //                     'v9.1',
                //                     0.54
                //                 ],
                //                 [
                //                     'v9.0',
                //                     0.13
                //                 ],
                //                 [
                //                     'v5.1',
                //                     0.2
                //                 ]
                //             ]
                //         },
                //         {
                //             name: 'Edge',
                //             id: 'Edge',
                //             data: [
                //                 [
                //                     'v16',
                //                     2.6
                //                 ],
                //                 [
                //                     'v15',
                //                     0.92
                //                 ],
                //                 [
                //                     'v14',
                //                     0.4
                //                 ],
                //                 [
                //                     'v13',
                //                     0.1
                //                 ]
                //             ]
                //         },
                //         {
                //             name: 'Opera',
                //             id: 'Opera',
                //             data: [
                //                 [
                //                     'v50.0',
                //                     0.96
                //                 ],
                //                 [
                //                     'v49.0',
                //                     0.82
                //                 ],
                //                 [
                //                     'v12.1',
                //                     0.14
                //                 ]
                //             ]
                //         }
                //     ]
                // },
                exporting: {
                    chartOptions: {
                        chart: {
                            style: {
                                fontFamily: 'monospace'
                            }
                        }
                    }
                }
            });
        });
    </script>
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
                delay: 2500, // ganti ke 3000 ms = 3 detik
                disableOnInteraction: false, // biar tetap jalan meskipun user klik/geser
            },
            speed: 600, // durasi transisi geser (ms),
            scrollbar: {
                el: '.swiper-scrollbar',
                draggable: true,
            },
        });
    </script>
@endpush
