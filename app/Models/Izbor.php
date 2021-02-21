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
        // naziv
        $sql = "SELECT TABLE_NAME AS naziv
                FROM INFORMATION_SCHEMA.TABLES
                WHERE TABLE_SCHEMA = '{$baza}';";
        return $this->fetch($sql);
    }

    public function polja($baza, $tabela)
    {
        // Field, Type, Null, Key, Default, Extra
        $sql = "SHOW COLUMNS FROM {$baza}.{$tabela};";

        return $this->fetch($sql);
    }

    public function kljucevi($baza, $tabela)
    {
        // Table, Non_unique, Key_name, Seq_in_index, Column_name
        // Collation, Cardinality, Sub_part, Packed, Null, Index_type, Comment, Index_comment
        $sql = "SHOW INDEX FROM {$baza}.{$tabela};";

        return $this->fetch($sql);
    }

    // koje tabele referencira ova tabela (belongsTo)
    public function vezeOdTabele($baza, $tabela)
    {
        $sql = "SELECT CONSTRAINT_NAME, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE REFERENCED_TABLE_SCHEMA = '{$baza}' AND TABLE_NAME = '{$tabela}'";

        return $this->fetch($sql);
    }

    // koje tabele referenciraju ovu tabelu (hasMany)
    public function vezeKaTabeli($baza, $tabela)
    {
        $sql = "SELECT CONSTRAINT_NAME, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE REFERENCED_TABLE_SCHEMA = '{$baza}' AND REFERENCED_TABLE_NAME = '{$tabela}'";

        return $this->fetch($sql);
    }

    // nije moguce odrediti belongsToMany ???
}
