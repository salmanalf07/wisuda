<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\AntrianModels;
use App\Mail\antriansmail;
use App\Models\antrian64;
use App\Models\mahasiswa64;

class DaftarController extends Controller
{
    public function search_nim(Request $request)
    {
        $get = DB::table('mahasiswa')
            ->select('nim')
            ->where('nim', $request->card)
            ->first();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function search_maha(Request $request)
    {
        $get = DB::table('mahasiswa')
            ->where('nim', $request->nim)
            ->first();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function search_maha64(Request $request)
    {
        $get = mahasiswa64::with('antrian')
            ->where('nim', $request->nim)
            ->where('card', $request->wisuda)
            ->first();


        $berkas = DB::table('berkas')
            ->whereNotIn('id', str_split($get->keterangan))
            ->get();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json([$berkas, $get]);
    }

    public function skip_maha64(Request $request)
    {
        $get = antrian64::where('nim', $request->nim)
            ->update([
                'skip' => 1,
            ]);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function store(Request $request)
    {
        //get_data mahasiswa
        $get_maha = DB::table('mahasiswa')
            ->where('nim', $request->nim)
            ->first();

        $record = DB::table('antrian')
            ->latest('id')
            ->first();
        if ($record === null) {
            $antrian = 1;
        } else {
            if (date("Y-m-d", strtotime($record->created_at)) != date("Y-m-d")) {
                $antrian = 1;
            } else {
                $antrian = $record->no_urut + 1;
            }
        }
        //sprintf('%04d', $antrian) untuk tambah 0 4

        $post = new AntrianModels();
        $post->nim = $request->nim;
        $post->jenis = 'A';
        $post->no_urut = $antrian;
        $post->bukti_pic = '';
        $post->status = 'open';
        $post->save();

        $data = [
            $get_maha,
            $post,
            'antrian' => $request->jenis . sprintf('%04d', $antrian)
        ];

        //Mail::to($get_maha->email)->send(new antriansmail($data));

        return response()->json($data);
    }
}
