<?php
namespace App\Models;

use \ActiveRecord\Model as Model;

final class Usuario extends Model
{
    public function passwordVerify(String $pswInput)
    {
        return \password_verify($pswInput, $this->senha);
    }
}