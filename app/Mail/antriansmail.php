<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class antriansmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('wisuda.subek@binus.edu')
            ->subject('Nomor Antrian Wisuda')
            ->view('mails.mailantrian')
            ->with(
                [
                    'testVarOne' => '1',
                    'testVarTwo' => '2',
                ]
            )
            ->attach(public_path('/assets/image') . '/logo.png', [
                'as' => 'logo.png',
                'mime' => 'image/png',
            ]);
    }
}
