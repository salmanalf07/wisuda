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
        //ttd
        $ttd = $request->file('ttd');
        $filenames = $request->nim_r . '-' . uniqid() . '- canvas.jpeg';
        Storage::disk('public')->put('paketWisuda/' . $get->thWisuda . '/ttd/' . $filenames,  File::get($ttd));

        if ($get) {

            $save = paketWisuda::findOrFail($get->id);
            $save->nim = $request->nim_r;
            $save->bukti_pic = $filename;
            $save->bukti_ttd = $filenames;
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
            // ->where('status', '=', 'close')
            ->get();

        // Membuat view untuk konten PDF dengan data mahasiswa
        $pdfContent = view('paketWisuda.r_paketWisuda', ['mahasiswa' => $mahasiswa])->render();

        // Membuat view untuk header dan footer
        $headerContent = view('paketWisuda.header')->render();
        $footerContent = view('paketWisuda.footer')->render();

        $pdf = PDF::loadView('paketWisuda.pdf_template', [
            'headerContent' => $headerContent, // Menggunakan header yang telah dibuat
            'footerContent' => $footerContent, // Menggunakan footer yang telah dibuat
            'mahasiswa' => $mahasiswa,
            'pdfContent' => $pdfContent,
        ]);
        return $pdf->stream('nama_file_pdf.pdf');
    }
}
