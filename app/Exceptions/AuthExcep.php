<?php

namespace App\Exceptions;

use Exception;

class AuthExcep extends Exception
{
    public static function notprovide()
    {

        $message = 'there is no Access token';

        $exception = new static($message, 403);
    }

    public static function notmatch()
    {

        $message = 'the Access token Not Valid';

        $exception = new static($message, 403);
    }
/*
    public static function notprovide()
    {

        $message = 'there is no Access token';

        $exception = new static($message, 403);
    }*/

}
