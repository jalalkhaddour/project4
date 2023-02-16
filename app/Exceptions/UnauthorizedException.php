<?php

namespace App\Exceptions;

use Exception;
use PhpParser\Node\Scalar\String_;

class UnauthorizedException extends Exception
{

    private $requiredPermission='';



    public static function forPermission($permission): self
    {


        $message = 'User does not have the right necessary permission which is [ '.$permission.' ]';

        $exception = new static($message,403);
        $exception->requiredPermission = $permission;

        return $exception;
    }


    public static function notLoggedIn(): self
    {
        return new static(403, 'User is not logged in.', null, []);
    }


    public function getRequiredPermission(): String
    {
        return $this->requiredPermission;
    }

}
