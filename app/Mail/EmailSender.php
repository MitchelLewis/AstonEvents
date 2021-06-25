<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Mailjet\LaravelMailjet\Facades\Mailjet;
use \Mailjet\Resources;


class EmailSender extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handles sending mail with the specified recipient email and message to send.
     * True on success, false on failure.
     * 
     * @param String $recipient - Recipient email
     * @param String $msg - Message body for email
     * @return boolean
     * 
     */
    public function sendMail(String $recipient, String $msg) {
        $mj = Mailjet::getClient();
        $body = [
            'FromEmail' => "180212228@aston.ac.uk",
            'FromName' => "Aston Events",
            'Subject' => "You have a new email from AstonEvents",
            'Text-part' => $msg,
            'Recipients' => [['Email' => $recipient]]];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
    if ($response->success())
      return true;
    else
      return false;
    }
}