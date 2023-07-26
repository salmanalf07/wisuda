<?php

namespace App\Http\Controllers;

use App\Models\paketWisuda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade as PDF;

class paketWisudaController extends Controller
{
    public function search(Request $request)
    {
        $get = paketWisuda::where('nim', $request->nim)
            ->first();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }
    public function skip(Request $request)
    {
        $get = paketWisuda::where('nim', $request->nim)
            ->update([
                'skip' => 1,
            ]);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function store(Request $request)
    {
        $get = paketWisuda::where('nim', $request->nim_r)
            ->first();

        //foto
        $cover = $request->file('image');
        $filename = $request->nim_r . '-' . uniqid() . '.jpeg';
        //$extension = $cover->getClientOriginalExtension();
        Storage::disk('public')->put('paketWisuda/' . $get->thWisuda . '/' . $filename,  File::get($cover));

        if ($get) {

            $save = paketWisuda::findOrFail($get->id);
            $save->nim = $request->nim_r;
            $save->bukti_pic = $filename;
            $save->status = "close";
            $save->user = $request->ip();
            $save->save();
        }


        return response()->json($save);
    }

    function rPaketWisuda(Request $request, $id)
    {
        $mahasiswa = paketWisuda::where('thWisuda', '=', $id)
            // ->where('skip', '=', null)
            ->where('status', '=', 'open')->get();
        // ->paginate(20);
        // return view('paketWisuda/r_paketWisuda', ['mahasiswa' => $mahasiswa]);
        $header = view('/paketWisuda/footer')->render();
        $footer = view('/paketWisuda/header')->render();
        $pdfContent = view('/paketWisuda/r_paketWisuda', $mahasiswa)->render();

        $pdf = PDF::loadHTML($header . $pdfContent . $footer);
        return $pdf->stream('nama_file_pdf.pdf');
    }
}
