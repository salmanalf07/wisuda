<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailReaktifJob;
use App\Mail\antriansmail;
use App\Models\antrian64;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\AntrianModels;
use Barryvdh\DomPDF\Facade as PDF;

class AntrianController extends Controller
{
    public function index()
    {
        $antrian = DB::table('antrian')
            ->selectRaw('count(*) as total')
            ->where('status', 'open')
            ->first();

        $antrian_1 = DB::table('antrian')
            ->where('status', 'open')
            ->first();

        if ($antrian_1 != null) {
            $antrian_one = $antrian_1->jenis . sprintf('%03d', $antrian_1->no_urut);
            $antrian_oneid = $antrian_1->id;

            $antrian_2 = AntrianModels::where('status', 'open')->skip(1)->take(1)->first();
            if ($antrian_2 === null) {
                $antrian_two = 0;
            } else {
                $antrian_two = $antrian_2->jenis . sprintf('%03d', $antrian_2->no_urut);
            }
        } else {
            $antrian_one = 0;
            $antrian_two = 0;
            $antrian_oneid = 0;
        }

        return view('v_antrian', [
            'antrian' => $antrian,
            'antrian_one' => $antrian_one,
            'antrian_oneid' => $antrian_oneid,
            'antrian_two' => $antrian_two
        ]);
    }

    public function dashboard()
    {
        $antrian = DB::table('antrian')
            ->selectRaw('count(*) as total')
            ->where('status', 'open')
            ->first();

        $antrian_1 = DB::table('antrian')
            ->where('status', 'open')
            ->first();

        if ($antrian_1 != null) {
            $antrian_one = $antrian_1->jenis . sprintf('%03d', $antrian_1->no_urut);
            $get = DB::table('mahasiswa')
                ->where('nim', $antrian_1->nim)
                ->first();
            $nam_antrian = $get->nama_mahasiswa . ' - ' . $get->nim;

            $antrian_2 = AntrianModels::where('status', 'open')->skip(1)->take(1)->first();
            if ($antrian_2 === null) {
                $antrian_two = 0;
            } else {
                $antrian_two = $antrian_2->jenis . sprintf('%03d', $antrian_2->no_urut);
            }
        } else {
            $nam_antrian = '';
            $antrian_one = 0;
            $antrian_two = 0;
        }

        return view('v_dashboard', [
            'antrian' => $antrian,
            'antrian_one' => $antrian_one,
            'nam_antrian' => $nam_antrian,
            'antrian_two' => $antrian_two
        ]);
    }

    public function search_antrian(Request $request)
    {
        //$str = str_replace('00', '', $request->antr_one);
        //masalah, harus ambil 2 dijit terakhir
        //$string1 = substr($str, 0, 1);
        //$string2 = substr($str, 1);
        $get = DB::table('antrian')
            ->select('nim', 'id AS id_antrian')
            //->where('no_urut', $string2)
            ->where('id', $request->antr_one)
            ->first();
        $get_m = DB::table('mahasiswa')
            ->select('nim', 'id', 'jurusan', 'nama_mahasiswa')
            ->where('nim', $get->nim)
            ->first();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json(array($get_m, $get));
    }

    public function store_antr(Request $request)
    {
        //foto
        $cover = $request->file('image');
        $filename = $request->nim_r . '-' . $request->id . '.jpeg';
        //$extension = $cover->getClientOriginalExtension();
        Storage::disk('public')->put($filename,  File::get($cover));
        //canvas
        $canvas = $request->file('ttd');
        $filenames = $request->nim_r . '-' . $request->id . '- canvas' . '.png';
        //$extension = $canvas->getClientOriginalExtension();
        Storage::disk('ttd')->put($filenames,  File::get($canvas));

        $save = AntrianModels::findOrFail($request->id);
        $save->id = $request->id;
        $save->bukti_pic = $filename;
        $save->ttd = $filenames;
        $save->keterangan = $request->keterangan;
        $save->status = "close";
        $save->keterangan = implode(",", $request->berkas);
        $save->save();

        return response()->json($save);
    }

    public function store_antr64(Request $request)
    {
        $get = DB::table('mahasiswa64')
            ->where('nim', $request->nim_r)
            ->first();
        $get_id = DB::table('antrian64')
            ->where('nim', $request->nim_r)
            ->where('bukti_pic', null)
            ->first();

        //foto
        $cover = $request->file('image');
        $filename = $request->nim_r . '-' . uniqid() . '.jpeg';
        //$extension = $cover->getClientOriginalExtension();
        Storage::disk('public64')->put($filename,  File::get($cover));

        if ($get_id) {

            $save = antrian64::findOrFail($get_id->id);
            // $save->id = $request->id;
            $save->nim = $request->nim_r;
            $save->bukti_pic = $filename;
            $save->status = "close";
            $save->keterangan = implode(",", $request->berkas);
            $save->save();
            if ($get->email) {
                SendMailReaktifJob::dispatch($get_id->id);
            }
        } else {
            $save = new antrian64();
            $save->nim = $request->nim_r;
            $save->bukti_pic = $filename;
            $save->status = "close";
            $save->keterangan = implode(",", $request->berkas);
            $save->save();

            if ($get->email) {
                SendMailReaktifJob::dispatch($save->id);
            }
        }


        // $data = antrian64::find($get_id->id);


        return response()->json($save);
    }

    public function cetak_pdf()
    {
        $pegawai = antrian64::find(5);

        $path = base_path('surat-piutang-B23.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $img = file_get_contents($path);
        $pic = 'data:image/' . $type . ';base64,' . base64_encode($img);

        $pathh = public_path() . '/assets/images64/' . $pegawai->bukti_pic;
        $typee = pathinfo($pathh, PATHINFO_EXTENSION);
        $imgg = file_get_contents($pathh);
        $picc = 'data:image/' . $typee . ';base64,' . base64_encode($imgg);

        $get = DB::table('mahasiswa64')
            ->where('nim', $pegawai->nim)
            ->first();

        $berkas = DB::table('berkas')
            ->whereIn('id', str_split($pegawai->keterangan))
            ->get();

        $date = date("d m Y H:i", strtotime($pegawai->updated_at));

        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif'])->loadView('wisuda64/v_wacom', compact('pic', 'picc'), ['data' => $pegawai, 'berkas' => $berkas, 'tanggal' => $date, 'nama' => $get->nama_mahasiswa]);
        return $pdf->stream('laporan-pegawai-pdf');
    }

    public function cetak_page($id)
    {
        $get = DB::table('antrian')
            ->where('id', $id)
            ->first();
        $get_1 = DB::table('mahasiswa')
            ->where('nim', $get->nim)
            ->first();
        $date = date("d F Y H:i", strtotime($get->updated_at));
        $berkas = DB::table('berkas')
            ->whereIn('id', str_split($get->keterangan))
            ->get();
        return view('v_wacom', [
            'id' => $get_1->id,
            'foto' => $get->bukti_pic,
            'nim' => $get->nim,
            'nama' => $get_1->nama_mahasiswa,
            'ttd' => $get->ttd,
            'tanggal' => $date,
            'berkas' => $berkas,
        ]);
    }

    public function send_total()
    {

        $nim_data = [
            2201738964, 2201739336, 2201739494, 2201747994, 2201748145, 2201748561, 2201748694, 2201749021, 2201763663,
            2201763751, 2201763783, 2201765422, 2201765832, 2201767150, 2201770523,
            2201771242, 2201803603, 2201813005, 2201732525, 2201732310, 2101717952,
            2101686732, 2101679670, 2101671926, 2001614436, 2201776874, 2201777220,
            2201777290, 2201777340, 2201772314, 2201773563, 2201774982, 2201775133,
            2201776930, 2201862814, 2301964975, 2301965385, 2301965555, 2301966154,
            2201823486, 2101699073, 2201818920, 2201815963, 2101703783, 2101773890,
            2201799013, 2101778664, 2301969326, 2301969433, 2301969692, 2301971444,
            2101757350, 2101764910, 2101772660, 2301964842, 2301965284, 2301965366,
            2301965422, 2301965750, 2301966633, 2301966684, 2301969175, 2001921866,
            2201798383, 2101678806, 2101668055, 2101666812, 2101658653, 2101724806,
            2001619140, 2201756815, 2201756121, 2201753145, 2201752975, 2201732954,
            1901506866, 2101650650, 2101639982, 2101717536, 2101694910, 2101684802,
            2201833732, 2201818731, 2201817672, 2201817546, 2201817514, 2201815585,
            2201815250, 2201766223, 2201765605, 2201764092, 2201763272, 2201795671,
            2201789201, 2201788110, 2201787316, 2201786534, 2201784680, 2201784636,
            2201781722, 2201780682, 2201776520, 2101678693, 2201775354, 2201772743, 2201772245, 2201772011, 2201769686, 2201769244, 2201810836
        ];

        $updsj = collect($nim_data)->filter()->all();

        for ($i = 0; $i < count($updsj); $i++) {
            $get = DB::table('mahasiswa64')
                ->where('nim', $updsj[$i])
                ->first();
            $get_id = DB::table('antrian64')
                ->where('nim', $updsj[$i])
                ->first();

            SendMailReaktifJob::dispatch($get_id);
        }

        return $updsj;
    }
}
