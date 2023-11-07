<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahasiswa64 extends Model
{
    use HasFactory;
    protected $table = "mahasiswa64";
    protected $primaryKey = 'id';

    protected $fillable = [
        'card',
        'nim',
        'nama_mahasiswa',
        "acadCareer",
        "acadGroup",
        'jurusan',
        'email',
        'loket',
        'sesi'
    ];

    public function antrian()
    {
        return $this->hasMany(antrian64::class, 'nim', 'nim');
    }
}
