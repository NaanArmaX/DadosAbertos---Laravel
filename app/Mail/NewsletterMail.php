<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $news; // Para passar as notícias ao e-mail

    public function __construct($news)
    {
        $this->news = $news;
    }

    public function build()
    {
        return $this->view('emails.newsletter')
                    ->with([
                        'news' => $this->news,
                    ]);
    }
}
