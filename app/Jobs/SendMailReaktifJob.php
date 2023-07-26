<?php

namespace App\Jobs;

use App\Models\antrian64;
use App\Models\reaktif;
use App\Models\Template;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendMailReaktifJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pegawai = antrian64::with('mahasiswa')->find($this->data);

        $path = base_path('surat-piutang-B23.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $img = file_get_contents($path);
        $pic = 'data:image/' . $type . ';base64,' . base64_encode($img);

        $pathh = public_path() . '/assets/images/' . $pegawai->mahasiswa->card . '/' . $pegawai->bukti_pic;
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

        $str = explode(" ", $get->campus);

        if ($str[1] == 'Alam-Sutera' || $str[1] == 'Senayan'  || $str[1] == 'Kemanggisan' || $str[1] == 'Online') {
            $tempat = "Jakarta";
        } elseif ($str[1] = 'Bekasi') {
            $tempat = "Bekasi";
        } else {
            $tempat = $str[1];
        }

        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif'])->loadView('wisuda64/v_wacom', compact('pic', 'picc'), ['data' => $pegawai, 'berkas' => $berkas, 'tanggal' => $date, 'nama' => $get->nama_mahasiswa, 'tempat' => $tempat]);


        if ($get->email != null) {
            $dada['email'] = $get->email;
            $dada['subject'] = "WISUDA 67";
            $dada['nim'] = $pegawai->nim;

            Mail::send('emails.myTestMail', $dada, function ($message) use ($dada, $pdf) {
                //Mail::send('emails.myTestMail', $dada, function ($message) use ($dada) {
                $message->to($dada['email'])
                    ->subject($dada['subject'])
                    ->attachData($pdf->output(), $dada['nim'] . ".pdf");
            });

            // check for failures
            if (!Mail::failures()) {
                $postt = antrian64::find($this->data);
                $postt->sender_at = date("Y-m-d H:i:s", strtotime('now'));
                $postt->save();
            }
        }
    }
}
