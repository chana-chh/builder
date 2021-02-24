<?php

namespace App\Models;

use App\Classes\Model;

class Izbor extends Model
{
    protected $table = 'izbor';

    public function baze()
    {
        // Database
        $sql = "SHOW DATABASES;";
        return $this->fetch($sql);
    }

    public function tabele($baza)
    {
        $sql = "SELECT TABLE_NAME AS naziv
                FROM INFORMATION_SCHEMA.TABLES
                WHERE TABLE_SCHEMA = '{$baza}';";
        return $this->fetch($sql);
    }

    // koje tabele referencira ova tabela (belongsTo)
    public function vezeOdTabele($baza, $tabela)
    {
        $sql = "SELECT TABLE_SCHEMA AS baza, TABLE_NAME AS tabela, CONSTRAINT_NAME AS naziv, COLUMN_NAME AS kolona,
                        ORDINAL_POSITION AS pozicija, REFERENCED_TABLE_NAME AS ref_tabela, REFERENCED_COLUMN_NAME AS ref_kolona
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE REFERENCED_TABLE_SCHEMA = '{$baza}' AND TABLE_NAME = '{$tabela}';";
        return $this->fetch($sql);
    }

    // koje tabele referenciraju ovu tabelu (hasMany)
    public function vezeKaTabeli($baza, $tabela)
    {
        $sql = "SELECT TABLE_SCHEMA AS baza, TABLE_NAME AS tabela, CONSTRAINT_NAME AS naziv, COLUMN_NAME AS kolona,
                        ORDINAL_POSITION AS pozicija, REFERENCED_TABLE_NAME AS ref_tabela, REFERENCED_COLUMN_NAME AS ref_kolona
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE REFERENCED_TABLE_SCHEMA = '{$baza}' AND REFERENCED_TABLE_NAME = '{$tabela}';";
        return $this->fetch($sql);
    }
}
