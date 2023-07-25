<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class antrian64 extends Model
{
    use HasFactory;
    protected $table = "antrian64";
    protected $primaryKey = 'id';

    protected $fillable = [
        'nim',
        'bukti_pic',
        'ttd',
        'status',
        'keterangan',
        'updTimeKet',
        'user',
        'sender_at'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(mahasiswa64::class, 'nim', 'nim');
    }
}
