<?php
namespace App\Models;

use App\Classes\Model;

class Tip extends Model
{
    protected $table = 'tipovi';

    public function meso()
    {
        return $this->hasMany('App\Models\Meso', 'tip_id');
    }
}