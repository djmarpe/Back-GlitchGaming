<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Verificar extends Mailable
{
    use Queueable, SerializesModels;

    public $nombreUsuario;
    public $url;
    
    public function __construct($username, $url)
    {
        $this->nombreUsuario = $username;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verificar');
    }
}
