<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Preguntas extends Mailable
{
    use Queueable, SerializesModels;

    
    public $subject = "Preguntas";
    
    public $nombre ="Aqui va el nombre";
    
    public $de = "emailEmisor@gmail.com";
    
    public $mensaje = "cuerpo del mensaje";
            
    public function __construct($mensaje)
    {
        $this->de = $mensaje['de'];
        $this->nombre = $mensaje['nombre'];
        $this->subject = $mensaje['asunto'];
        $this->mensaje = $mensaje['mensaje'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contactanos');
    }
}
