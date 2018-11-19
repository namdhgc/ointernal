<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\LeaveRequestMail;
use App\Mail\OvertimeMail;
use App\Mail\RegisterMail;
use App\Mail\ResetPasswordMail;
use Config;
use Mail;

class EmailController extends Controller
{
	public function sendMail($type, $data, $to, $cc = null, $bcc = null)
    {
    	try {

    		$mail = Mail::to($to);

		    if (isset($cc) && $cc != '' && $cc != null) {

		    	$mail->cc($cc);
		    }

		    if (isset($bcc) && $bcc != '' && $bcc != null) {

		    	$mail->bcc($bcc);
		    }

		    if ($type == Config::get('email_types.register')) {

		    	$mail->send(new RegisterMail($type, $data));

		    } else if ($type == Config::get('email_types.overtime')) {

		    	$mail->send(new OvertimeMail($type, $data));

		    } else if ($type == Config::get('email_types.leave_request')) {

		    	$mail->send(new LeaveRequestMail($type, $data));

		    } else if ($type == Config::get('email_types.reset_password')) {

		    	$mail->send(new ResetPasswordMail($type, $data));

		    }

		    return true;

    	} catch (Exception $e) {

    		return false;
    	}
    }
}