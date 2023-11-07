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
        "nama_mahasiswa",
        "acadCareer",
        "acadGroup",
        "jurusan",
        "campus",
        "email",
        "bukti_pic",
        "bukti_ttd",
        "skip",
        "status",
        "keterangan",
        "user",
    ];
}
