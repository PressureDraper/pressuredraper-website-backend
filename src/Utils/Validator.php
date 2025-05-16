<?php

namespace App\Utils;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class Validator
{

    public static function isValidEmail($email)
    {
        $validator = new EmailValidator();
        return $validator->isValid($email, new RFCValidation());
    }
}
