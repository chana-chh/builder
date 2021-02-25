<?php
namespace App\Models;

use App\Classes\Model;

class Meso extends Model
{
    protected $table = 'meso';

    public function tip()
    {
        return $this->belongsTo('App\Models\Tip', 'tip_id');
    }
}