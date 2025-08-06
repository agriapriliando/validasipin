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
        <div class="row align-items-center">
            <div class="col-lg-6 mt-4 wow fadeInUp">
                <h1 class="mb-4">Layanan Penerbitan Surat Validasi PIN</h1>
                <p class="text-lg mb-5">Operator PISN pada UPT TIPD melakukan pengecekan Status Eligible Calon Lulusan</p>

                <a target="_blank" href="https://pisn.kemdiktisaintek.go.id/" class="btn btn-primary btn-split ml-2">Cari Tahu PISN? <div class="fab"><span class="mai-question"></span></div></a>
                <a target="_blank" href="https://wa.me/6282352127683" class="btn btn-outline border text-secondary">Tanya Operator Kampus?</a>
            </div>
            <div class="col-lg-6 mt-4 wow fadeInUp">
                <div class="subhead">Formulir</div>
                <h2 class="title-section">Penerbitan Surat Validasi PIN</h2>
                <div class="divider"></div>
                @if (session()->has('status'))
                    <div class="alert alert-warning">{{ session('status') }}</div>
                @endif
                <form wire:submit.prevent="cekData">
                    <div class="py-2">
                        <input type="text" wire:model.live="nim" class="form-control @error('nim') is-invalid @enderror" placeholder="NIM Contoh : 1223233323">
                        <small class="form-text text-muted">*Masukan NIM Tanpa Menggunakan Titik</small>
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="py-2">
                        <input type="text" wire:model.live="nohp" class="form-control @error('nohp') is-invalid @enderror" placeholder="No HP">
                        <small class="form-text text-muted">*Masukan No HP Whatsapp Aktif</small>
                        @error('nohp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill mt-4" @if ($errors->any()) disabled @endif>Pendaftaran</button>
                    <button wire:loading wire:target="cekData" class="btn btn-primary rounded-pill mt-4" @if ($errors->any()) disabled @endif>Sedang Proses, Mohon Tunggu</button>
                </form>
            </div>
        </div>
    </div>
</div>
