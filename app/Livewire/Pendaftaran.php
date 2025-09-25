<?php

namespace App\Livewire;

use App\Helpers\Setting;
use App\Models\Optional;
use App\Models\Tambahan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Pendaftaran extends Component
{
    #[Validate('required', message: 'NIM harus diisi')]
    #[Validate('regex:/^[^\.]+$/', message: 'NIM tidak boleh mengandung titik (.))')]
    #[Validate('numeric', message: 'Hanya boleh diisi angka tanpa karakter lainnya')]
    public $nim = '';

    #[Validate('required', message: 'No HP harus diisi')]
    #[Validate('numeric', message: 'Harus Angka')]
    public $nohp = '';

    public $seriesData = [];

    public $cek_nim;
    public $link_surat = "";
    public $status_eligible;

    public $total;
    public $total_eligible;
    public $total_proses;
    public $total_nina;

    public function mount()
    {
        $this->total = User::count();
        $this->total_eligible = User::where('status_eligible', 'Eligible')->count();
        $this->total_proses = User::where('status_eligible', '!=', 'Eligible')->count();
        $this->total_nina = User::whereNotNull('nina')->where('nina', '<>', '')->count();

        // Ambil jumlah mahasiswa per prodi
        $result = User::select('prodi', DB::raw('COUNT(*) as total'))
            ->groupBy('prodi')
            ->get();

        // Ubah ke format Highcharts
        $this->seriesData = $result->map(function ($row) {
            return [
                'name'      => $row->prodi ?? 'Tidak Ada Prodi',
                'y'         => (int) $row->total,
                'drilldown' => $row->prodi, // bisa dipakai untuk drilldown detail
            ];
        });
    }
    public function updatedCekNim()
    {
        $mhs = User::where('nim', $this->cek_nim)->first();
        if ($mhs) {
            $this->status_eligible = $mhs->status_eligible;
            $this->link_surat = url('report/' . $mhs->id);
        } else {
            $this->status_eligible = "";
            $this->link_surat = "";
        }
    }


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
                // cek NIM jika ada Mei Minarni
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
                    'password' => bcrypt('123456'),
                    'id_mahasiswa' => $data['id_mahasiswa'],
                    'nama_mahasiswa' => $data['nama_mahasiswa'],
                    'tempat_lahir' => $datadetail['tempat_lahir'],
                    'tgl_lahir' => Carbon::parse($datadetail['tanggal_lahir'])->format('Y-m-d'),
                    'alamat' => $alamat,
                    'prodi' => $data['nama_program_studi'],
                    'nohp' => substr($this->nohp, 0, 2) == '62' ? '0' . substr($this->nohp, 1) : $this->nohp,
                    'status_eligible' => 'Belum Cek',
                ]);

                // insert berkas mahasiswa ke folder dan database
                $this->saveberkas($data['id_mahasiswa'], $this->nim . '_' . $data['nama_mahasiswa'] . '_' . date('Ymd_His'));

                return redirect('report/' . $datamhs->id);
            } else {
                session()->flash('status', 'NIM Anda : ' . $nim . ' Tidak Terdaftar di PDDikti, Coba Kembali');
                return;
            }
        }
    }

    use WithFileUploads;

    #[Validate('required|file|mimes:pdf,jpg,jpeg,png')]
    public $berkas;

    protected $messages = [
        'berkas.required' => 'File wajib diupload.',
        'berkas.file'     => 'Input harus berupa file.',
        'berkas.mimes'    => 'File hanya boleh dalam format PDF, JPG, JPEG, PNG, atau WEBP.',
    ];

    public function saveberkas($id, $nama_berkas)
    {
        $extension = strtolower($this->berkas->getClientOriginalExtension());
        $fileName = $nama_berkas . '.' . $extension;
        $sizeKB = $this->berkas->getSize() / 1024;

        // Pakai ImageManager driver GD (bisa juga 'imagick' kalau terinstall)
        $manager = new ImageManager(new Driver());

        if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']) && $sizeKB > 500) {
            $image = $manager->read($this->berkas->getRealPath());

            // langsung set kualitas 60
            $compressed = (string) $image->encodeByExtension('jpg', quality: 60);
            $sizeKB = strlen($compressed) / 1024;

            // jika masih > 1000KB, turunkan
            if ($sizeKB > 1000) {
                $compressed = $image->encodeByExtension('jpg', quality: 50);
            }

            // jika masih > 1000KB, turunkan
            if ($sizeKB > 1000) {
                $compressed = $image->encodeByExtension('jpg', quality: 50);
            }

            // jika masih > 1000KB, turunkan
            if ($sizeKB > 1000) {
                $compressed = $image->encodeByExtension('jpg', quality: 50);
            }

            // jika masih > 1000KB, turunkan
            if ($sizeKB > 1000) {
                $compressed = $image->encodeByExtension('jpg', quality: 50);
            }

            // jika masih > 1000KB, turunkan
            if ($sizeKB > 1000) {
                $compressed = $image->encodeByExtension('jpg', quality: 50);
            }
            Storage::disk('public')->put("berkas/$fileName", $compressed);
            $path = "berkas/$fileName";
        } else {
            $path = $this->berkas->storeAs('berkas', $fileName, 'public');
        }

        // Update database
        User::where('id_mahasiswa', $id)->update(['berkas' => $path]);
    }
    public function render()
    {
        return view('livewire.pendaftaran', [
            'warning' => Tambahan::whereJudul('Warning')->first(),
        ]);
    }
}
