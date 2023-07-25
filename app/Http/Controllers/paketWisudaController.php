<?php

namespace App\Http\Controllers;

use App\Models\paketWisuda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
}
