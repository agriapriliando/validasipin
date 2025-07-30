<div class="container">
    <style>
        span.btnedit {
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
    <div class="row">
        <div class="col-12 mt-4">
            <h3 class="post-title">Daftar Ajuan Validasi PIN</h3>
            <div class="row">
                <div class="col-12 col-md-4">
                    <select wire:model.live="selectedProdi" class="form-control form-control-sm">
                        <option value="">=== Pilih Program Studi ===</option>
                        @foreach ($allprodi as $item)
                            <option>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <input type="text" wire:model.live.debounce.250ms="search" class="form-control form-control-sm" placeholder="Cari Nama atau NIM" aria-label="Search">
                </div>
                <div class="col-6 col-md-2">
                    <select wire:model.live="perPage" class="form-control form-control-sm">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="{{ $users->total() }}">All</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select wire:model.live="status" class="form-control form-control-sm">
                        <option value="">======</option>
                        <option value="Belum Cek">Belum Cek</option>
                        <option value="Eligible">Eligible</option>
                        <option value="Non Eligible">Non Eligible</option>
                    </select>
                </div>
            </div>
            <div x-data="{
                copyTable() {
                    let rows = Array.from(document.querySelectorAll('#tabel-users tr'));
                    let text = rows.map(row => {
                        // Ambil hanya data dari <td> (atau <th> kalau mau)
                        return Array.from(row.querySelectorAll('th,td'))
                            .map(cell => cell.innerText)
                            .join('\t'); // Tab sebagai pemisah kolom
                    }).join('\n'); // Enter sebagai pemisah baris
            
                    // Copy ke clipboard
                    navigator.clipboard.writeText(text).then(() => {
                        alert('Data tabel berhasil disalin!');
                    });
                }
            }">
                <button class="btn btn-success btn-sm m-2" @click="copyTable">
                    Copy Data
                </button>
                <a class="btn btn-sm btn-primary m-2" target="_blank" href="https://docs.google.com/spreadsheets/d/1xttNvO8zF_FHAo70s25CYtVyepa_At0l_oWC5pCDTVE/edit?usp=sharing">Daftar Ajuan
                    Perubahan Data Mahasiswa</a>
                @if (session('status'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="alert alert-success mt-2 position-relative">
                        {{ session('status') }}
                        <button class="btn btn-sm btn-close" type="button" @click="show = false">&times;</button>
                    </div>
                @endif
                <div>
                    <span class="text-muted">Menampilkan {{ $users->count() }} dari {{ $users->total() }} data</span>
                </div>
                <div style="overflow-x:auto;">
                    <table class="table mt-3" id="tabel-users">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Mahasiswa</th>
                                <th scope="col">Status</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Prodi</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr x-data="{ open: false }">
                                    <th scope="row">
                                        {{ ($users->currentPage() - 1) * $users->perPage() + $loop->index + 1 }}
                                        <button @click="open = true" title="Hapus Data">
                                            <span style="color: rgb(111, 64, 181)" class="mai-trash"></span>
                                        </button>
                                        <a target="_blank" href="{{ url('report/' . $user->id) }}"><span class="mai-print"></span></a>
                                    </th>
                                    <td>
                                        {{ $user->nim . ' - ' . $user->nama_mahasiswa }}
                                        <div style="display: inline;">

                                            <!-- Modal Konfirmasi -->
                                            <div x-show="open" x-transition
                                                style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; z-index: 9999;">
                                                <div style="background: #fff; padding: 20px 24px; border-radius: 6px; min-width: 220px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15);"
                                                    @click.away="open = false">
                                                    <div style="margin-bottom: 16px; font-weight: bold;">Yakin ingin menghapus data {{ $user->nama_mahasiswa }} ini?</div>
                                                    <button style="background: #dc3545; color: #fff; border: none; padding: 5px 15px; border-radius: 3px; margin-right: 8px; cursor: pointer;"
                                                        @click="$wire.delete('{{ $user->nim }}'); open = false;">Ya, Hapus</button>
                                                    <button style="background: #6c757d; color: #fff; border: none; padding: 5px 15px; border-radius: 3px; cursor: pointer;"
                                                        @click="open = false">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @php
                                        $btnClass = 'secondary'; // default
                                        if ($user->status_eligible == '' || $user->status_eligible == 'Belum Cek') {
                                            $btnClass = 'warning';
                                        } elseif ($user->status_eligible == 'Eligible') {
                                            $btnClass = 'success';
                                        } elseif ($user->status_eligible == 'Non Eligible') {
                                            $btnClass = 'danger';
                                        }
                                    @endphp
                                    <td>
                                        <div x-data="{ open: false }" style="display:inline;">
                                            <button class="btn btn-outline-{{ $btnClass }} btn-sm" @click="open = true">
                                                {{ $user->status_eligible }}
                                            </button>

                                            <!-- Modal Konfirmasi -->
                                            <div x-show="open" x-transition
                                                style="position: fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3); display:flex; align-items:center; justify-content:center; z-index:9999;">
                                                <div style="background:#fff; padding: 20px 24px; border-radius:6px; min-width:220px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.15);"
                                                    @click.away="open = false">
                                                    <div style="margin-bottom: 16px; font-weight: bold;">
                                                        Yakin ingin mengubah status?
                                                    </div>
                                                    <button style="background: #007bff; color: #fff; border: none; padding: 5px 15px; border-radius: 3px; margin-right: 8px; cursor: pointer;"
                                                        @click="$wire.toggleStatusEligible('{{ $user->nim }}'); open = false;">Ya, Ubah</button>
                                                    <button style="background: #6c757d; color: #fff; border: none; padding: 5px 15px; border-radius: 3px; cursor: pointer;"
                                                        @click="open = false">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td x-data="{ edit: false }">
                                        <!-- TAMPILAN VIEW -->
                                        <div x-show="!edit"
                                            @click="
                                                    edit = true;
                                                    $wire.startEditKeterangan('{{ $user->nim }}', '{{ $user->keterangan }}')
                                                "
                                            style="cursor:pointer;">
                                            {{ $user->keterangan == '' ? '-' : $user->keterangan }}
                                            <span class="mai-pencil"></span>
                                        </div>

                                        <!-- TAMPILAN EDIT -->
                                        <form @click.outside="edit = false" x-show="edit" wire:submit.prevent="updateKeterangan('{{ $user->nim }}')" style="display:inline;">
                                            <input type="text" wire:model="editingKeteranganValue" class="form-control d-inline-block" style="width:120px;">
                                            <button type="submit" @click="edit = false">Simpan</button>
                                            <button type="button" @click="edit = false; $wire.editingKeteranganNim = null; $wire.editingKeteranganValue = ''">X</button>
                                        </form>
                                    </td>
                                    <td>{{ $user->prodi_singkat }}</td>
                                    <td>
                                        @if ($user->status_eligible == 'Eligible')
                                            <a target="_blank" href="{{ $user->link }}">
                                                <span class="mai-logo-whatsapp"></span>
                                                {{ $user->nohp }}
                                            </a>
                                        @else
                                            <span>{{ $user->nohp }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->tanggal_daftar }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->links('vendor.livewire.custom') }}
            </div>
        </div>
    </div>

</div>
