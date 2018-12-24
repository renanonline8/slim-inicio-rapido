<?php
namespace App\Models;

use \ActiveRecord\Model as Model;

final class Usuario extends Model
{
    public function passwordVerify(String $pswInput)
    {
        return \password_verify($pswInput, $this->senha);
    }

    public function hashPassword($psw)
    {
        return \password_hash(
            $psw,
            PASSWORD_DEFAULT,
            ['cost' == 12]
        );
    }
}