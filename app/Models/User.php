<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'password',
        'id_mahasiswa',
        'nama_mahasiswa',
        'nim',
        'tempat_lahir',
        'tgl_lahir',
        'alamat',
        'prodi',
        'nohp',
        'status_eligible',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Scope filter by prodi
    public function scopeProdi($query, $prodi)
    {
        if ($prodi) {
            return $query->where('prodi', $prodi);
        }
        return $query;
    }

    // Scope filter by search (nama/nim)
    public function scopeSearch($query, $term)
    {
        if ($term) {
            return $query->where(function ($q) use ($term) {
                $q->where('nama_mahasiswa', 'like', "%{$term}%")
                    ->orWhere('nim', 'like', "%{$term}%");
            });
        }
        return $query;
    }

    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->where('status_eligible', 'like', "%{$status}%");
        }
        return $query;
    }

    protected function tanggalDaftar(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at
                ? $this->created_at->format('d-m-Y H:i') . ' WIB'
                : null,
        );
    }

    protected function prodiSingkat(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->singkatanProdi($this->prodi)
        );
    }

    // Fungsi helper untuk menyingkat prodi
    private function singkatanProdi($nama)
    {
        // Contoh mapping manual, kamu bisa tambah sesuai kebutuhan
        $mapping = [
            'S1 Pendidikan Agama Kristen' => 'S1 PAK',
            'S1 Teologi (Akademik)'   => 'S1 Teo',
        ];

        // Return singkatan jika ada di mapping, kalau tidak ada, ambil 3 huruf awal tiap kata kedua dst.
        if (isset($mapping[$nama])) {
            return $mapping[$nama];
        }

        // Fallback: Ambil inisial kata kedua dst (S1 Pendidikan Teknik Mesin -> S1 PTM)
        $arr = explode(' ', $nama);
        if (count($arr) > 2) {
            $inisial = $arr[0] . ' ';
            for ($i = 1; $i < count($arr); $i++) {
                $inisial .= strtoupper($arr[$i][0]);
            }
            return $inisial;
        }
        return $nama;
    }
}
