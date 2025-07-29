<?php

namespace App\Livewire;

use App\Helpers\Setting;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Pendaftaran extends Component
{
    #[Validate('required', message: 'NIM harus diisi')]
    #[Validate('regex:/^[^\.]+$/', message: 'NIM tidak boleh mengandung titik (.))')]
    #[Validate('numeric', message: 'Hanya boleh diisi angka tanpa karakter lainnya')]
    public $nim = '';

    #[Validate('required', message: 'No HP harus diisi')]
    public $nohp = '';

    public function cekData()
    {
        $this->validate();
        $data = new Setting();
        $nim = $this->nim;
        // dd(User::where('nim', $nim)->first());

        // Cek jika user sudah ada
        if ($mhs = User::where('nim', $nim)->first()) {
            return redirect('report/' . $mhs->id);
        } else {
            // Format NIM lama
            // return redirect('/');
            if (substr($nim, 0, 2) < 20) {
                if ($nim == "1902111739") {
                    $nim = "19.02.11.17.39";
                } elseif ($nim == "1902111855") {
                    $nim = "19.02.11,1855";
                } else {
                    $nim = substr($nim, 0, 2) . '.' . substr($nim, 2, 2) . '.' . substr($nim, 4, 2) . '.' . substr($nim, 6);
                }
            }
            $data = $data->getData('GetListMahasiswa', '', "nim like '" . $nim . "'");
            // dd($data['error_code']);
            // cek jika koneksi gagal
            if ($data['error_code'] != 0) {
                session()->flash('status', 'Aplikasi PDDikti Pusat sedang Gangguan, Silahkan Tunggu Beberapa Saat Lagi');
                return;
            }

            if ($data['jumlah'] > 0) {
                // cek NIM jika Mei Minarni
                if ($data['data'][0]['nipd'] != '2002111922') {
                    // cek status keluar mahasiswa
                    if ($data['data'][0]['id_status_mahasiswa'] != null) {
                        session()->flash('status', 'Aplikasi ini hanya untuk Mahasiswa Aktif, Status Mahasiswa Anda : ' . $data['data'][0]['nama_status_mahasiswa']);
                        return;
                    }
                }

                $datadetail = new Setting();
                $datadetail = $datadetail->getData('GetBiodataMahasiswa', '', "id_mahasiswa = '" . $data['data'][0]['id_mahasiswa'] . "'");
                $datadetail = $datadetail['data'][0];

                $alamat = $datadetail['jalan'] . ', ' . $datadetail['nama_wilayah'] . ', ' . $datadetail['dusun'];
                // data mahasiswa by nim
                $data = $data['data'][0];

                // insert data mahasiswa ke database
                $datamhs = User::create([
                    'nim' => $this->nim,
                    'name' => $this->nim,
                    'password' => bcrypt($this->nim),
                    'id_mahasiswa' => $data['id_mahasiswa'],
                    'nama_mahasiswa' => $data['nama_mahasiswa'],
                    'tempat_lahir' => $datadetail['tempat_lahir'],
                    'tgl_lahir' => Carbon::parse($datadetail['tanggal_lahir'])->format('Y-m-d'),
                    'alamat' => $alamat,
                    'prodi' => $data['nama_program_studi'],
                    'nohp' => substr($this->nohp, 0, 2) == '62' ? '0' . substr($this->nohp, 1) : $this->nohp,
                    'status_eligible' => 'Belum Cek',
                ]);
                return redirect('report/' . $datamhs->id);
            } else {
                session()->flash('status', 'NIM Anda : ' . $nim . ' Tidak Terdaftar di PDDikti, Coba Kembali');
                return;
            }
        }
    }
    public function render()
    {
        return view('livewire.pendaftaran');
    }
}
