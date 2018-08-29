<?php
namespace App\Models;

use \ActiveRecord\Model as Model;

final class Upload extends Model
{
    static $before_create = array('generateExternalId');
    
    public function generateExternalId() {
        $this->id_externo = uniqid();
    }
}