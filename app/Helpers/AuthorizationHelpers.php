<?php
namespace App\Helpers;

class AuthorizationHelpers{

    public function abort_if(bool $condition, $code, $message)
    {
        if($condition){
            return redirect()->back()->with($message);
        }
    }
}
