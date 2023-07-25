<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class paketWisuda extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "thWisuda",
        "nim",
        "jurusan",
        "nama_mahasiswa",
        "campus",
        "email",
        "bukti_pic",
        "skip",
        "status",
        "keterangan",
        "user",
    ];
}
