<?php

namespace Spr\Base\Validates;

use Config;

class ReCaptcha
{
    public function validate(
        $attribute, 
        $value, 
        $parameters, 
        $validator
    ){
    
        
        $html       = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . Config::get('recaptcha.private_key') . "&response=" . $value );
        $response   = json_decode($html, true);
        
        return $response['success'];
    }

}