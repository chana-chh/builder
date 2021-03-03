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

    public function nepostoji(string $naziv, string $putanja)
    {
    	$rez = null;
    	$eskepovano = str_replace('\\', '\\\\\\\\', $putanja);
    	$sql = "SELECT * FROM {$this->table} WHERE naziv LIKE '%{$naziv}%' AND putanja LIKE '%{$eskepovano}%';";
        $rezultat = $this->fetch($sql);
        if (!empty($rezultat)) {
        	$rez = $rezultat[0]->id;
        }
        return $rez;
    }
}