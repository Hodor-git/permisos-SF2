<?php

namespace Permiso\GestionBundle\Utilidades;

/**
 * Clase utilidad para enviar correos electrónicos.
 */
class MailHelper
{
    protected $mailer;

    //El constructor crea una instancia de Swift Mailer
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    
    //Método para enviar correo
    public function sendEmail($from, $to, $body, $subject = '')
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body);

        $this->mailer->send($message);
    }
}