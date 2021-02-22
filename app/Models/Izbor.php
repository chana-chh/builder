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

        /*
        SELECT  INFORMATION_SCHEMA.COLUMNS.TABLE_SCHEMA AS baza, INFORMATION_SCHEMA.COLUMNS.TABLE_NAME AS tabela,
                INFORMATION_SCHEMA.COLUMNS.COLUMN_NAME AS polje, INFORMATION_SCHEMA.COLUMNS.DATA_TYPE AS tip,
                INFORMATION_SCHEMA.COLUMNS.CHARACTER_MAXIMUM_LENGTH AS duzina,
                INFORMATION_SCHEMA.COLUMNS.IS_NULLABLE AS nulabilno, INFORMATION_SCHEMA.COLUMNS.COLUMN_DEFAULT AS povrazumevano,
                INFORMATION_SCHEMA.COLUMNS.COLUMN_KEY AS kljuc,
		        veza_od.ref_tabela, veza_od.ref_polje
        FROM INFORMATION_SCHEMA.COLUMNS
        LEFT JOIN ( SELECT  INFORMATION_SCHEMA.KEY_COLUMN_USAGE.COLUMN_NAME,
                            INFORMATION_SCHEMA.KEY_COLUMN_USAGE.REFERENCED_TABLE_NAME AS ref_tabela,
                            INFORMATION_SCHEMA.KEY_COLUMN_USAGE.REFERENCED_COLUMN_NAME AS ref_polje
                    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                    WHERE REFERENCED_TABLE_SCHEMA = 'portal' AND TABLE_NAME = 'clanci') AS veza_od
        ON `INFORMATION_SCHEMA`.`COLUMNS`.`COLUMN_NAME` = veza_od.COLUMN_NAME
        WHERE INFORMATION_SCHEMA.COLUMNS.TABLE_SCHEMA = 'portal' AND INFORMATION_SCHEMA.COLUMNS.TABLE_NAME = 'clanci'
        */

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
