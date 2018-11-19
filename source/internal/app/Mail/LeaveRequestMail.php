<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Config;

class LeaveRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    private $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $data)
    {

        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $view = null;

        if ($this->type = Config::get('email_types.leave_request')) {

            $view = $this->view('emails.LeaveRequestMail');
        }

        return $view->with('data', $data);
    }
}
