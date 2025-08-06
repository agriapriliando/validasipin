<?php

namespace App\Livewire;

use App\Models\Tambahan;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Daftar extends Component
{
    use WithPagination;
    public $selectedProdi = null;
    public $allprodi;
    public $search = '';
    public $perPage = 10;
    public $status;
    public $angkatan;

    public $editingKeteranganNim = null;
    public $editingKeteranganValue = '';

    public $warning;

    public function mount()
    {
        $this->allprodi = User::pluck('prodi')->unique()->values();
        $this->warning = Tambahan::whereJudul('Warning')->first();
    }

    // Reset ke halaman 1 jika filter berubah
    public function updatedSelectedProdi()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function toggleStatusEligible($id)
    {
        $user = User::whereNim($id)->first();
        // Logic toggle status
        if ($user->status_eligible == 'Belum Cek') {
            $user->status_eligible = 'Eligible';
        } elseif ($user->status_eligible == 'Eligible') {
            $user->status_eligible = 'Non Eligible';
        } elseif ($user->status_eligible == 'Non Eligible') {
            $user->status_eligible = 'Belum Cek';
        }
        $user->save();
    }

    public function toggleWarning()
    {
        $this->warning = Tambahan::whereJudul('Warning')->first();
        if ($this->warning['isi'] == 'Aktif') {
            Tambahan::whereJudul('Warning')->update(['isi' => '0']);
        } else {
            Tambahan::whereJudul('Warning')->update(['isi' => 'Aktif']);
        }
    }

    public function delete($nim)
    {
        User::whereNim($nim)->delete();
        session()->flash('status', 'Data ' . $nim . ' berhasil dihapus!');
    }

    public function startEditKeterangan($nim, $keterangan)
    {
        $this->editingKeteranganNim = $nim;
        $this->editingKeteranganValue = $keterangan;
    }

    public function updateKeterangan($nim)
    {
        $user = User::where('nim', $nim)->first();
        if ($user) {
            $user->keterangan = $this->editingKeteranganValue;
            $user->save();
        }
        $this->editingKeteranganNim = null;
        $this->editingKeteranganValue = '';
    }

    public function render()
    {
        $users = User::prodi($this->selectedProdi)
            ->search($this->search)
            ->status($this->status)
            ->where('nim', 'like', $this->angkatan . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        // return $mhs;
        foreach ($users as $a) {
            if ($a->nohp[0] == 0) {
                $nohp = "62" . ltrim($a->nohp, $a->nohp[0]);
            } else {
                $nohp = $a->nohp;
            }
            $a['link'] = "https://wa.me/" . $nohp . "?text=Hai%2C%20" . $a->nama_mahasiswa . ".%0ASurat%20Validasi%20PIN%20bisa%20dicetak%20melalui%20Link%20berikut.%0Ahttps%3A%2F%2Fvalidasipin.tipdiaknpky.com%2Freport%2F" . $a->id . "%0A%0AJika%20terdapat%20kesalahan%20Nama%20atau%20Tanggal%20Lahir%20silahkan%20mengisi%20Formulir%20PDDikti%20di%20Link%20berikut.%0Ahttps%3A%2F%2Fiaknpky.ac.id%2Finfo%2Fupt-tipd-pddikti%0ATerima%20Kasih.";
        }

        return view('livewire.daftar', [
            'users' => $users,
        ]);
    }
}
