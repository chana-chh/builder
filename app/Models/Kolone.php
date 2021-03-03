<?php

namespace App\Models;

use App\Classes\Model;

class Kolone extends Model
{
    protected $table = 'kolone';

    public function polja($baza, $tabela)
    {
        $sql = "SELECT  INFORMATION_SCHEMA.COLUMNS.TABLE_SCHEMA AS baza, INFORMATION_SCHEMA.COLUMNS.TABLE_NAME AS tabela,
                        INFORMATION_SCHEMA.COLUMNS.ORDINAL_POSITION AS pozicija, INFORMATION_SCHEMA.COLUMNS.COLUMN_NAME AS naziv,
                        INFORMATION_SCHEMA.COLUMNS.DATA_TYPE AS tip, INFORMATION_SCHEMA.COLUMNS.CHARACTER_MAXIMUM_LENGTH AS duzina,
                        INFORMATION_SCHEMA.COLUMNS.IS_NULLABLE AS nulabilno, INFORMATION_SCHEMA.COLUMNS.COLUMN_DEFAULT AS podrazumevano,
                        INFORMATION_SCHEMA.COLUMNS.COLUMN_KEY AS kljuc,
                        veza_od.ref_tabela, veza_od.ref_kolona
                FROM INFORMATION_SCHEMA.COLUMNS
                LEFT JOIN ( SELECT  INFORMATION_SCHEMA.KEY_COLUMN_USAGE.COLUMN_NAME,
                                    INFORMATION_SCHEMA.KEY_COLUMN_USAGE.REFERENCED_TABLE_NAME AS ref_tabela,
                                    INFORMATION_SCHEMA.KEY_COLUMN_USAGE.REFERENCED_COLUMN_NAME AS ref_kolona
                            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                            WHERE REFERENCED_TABLE_SCHEMA = '{$baza}' AND TABLE_NAME = '{$tabela}') AS veza_od
                ON `INFORMATION_SCHEMA`.`COLUMNS`.`COLUMN_NAME` = veza_od.COLUMN_NAME
                WHERE INFORMATION_SCHEMA.COLUMNS.TABLE_SCHEMA = '{$baza}' AND INFORMATION_SCHEMA.COLUMNS.TABLE_NAME = '{$tabela}'
                ORDER BY pozicija ASC;";
        return $this->fetch($sql);
    }

    public function kljucevi($baza, $tabela)
    {
        $sql = "SELECT TABLE_SCHEMA AS baza, TABLE_NAME AS tabela, CONSTRAINT_NAME AS naziv, COLUMN_NAME AS kolona,
                        ORDINAL_POSITION AS pozicija, REFERENCED_TABLE_NAME AS ref_tabela, REFERENCED_COLUMN_NAME AS ref_kolona
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = '{$baza}' AND TABLE_NAME = '{$tabela}';";
        return $this->fetch($sql);
    }

    public function vezeaneTabele($baza, $tabela)
    {
        $sql = "SELECT TABLE_SCHEMA AS baza, TABLE_NAME AS tabela, CONSTRAINT_NAME AS naziv, COLUMN_NAME AS kolona,
                        ORDINAL_POSITION AS pozicija, REFERENCED_TABLE_NAME AS ref_tabela, REFERENCED_COLUMN_NAME AS ref_kolona
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE REFERENCED_TABLE_SCHEMA = '{$baza}' AND TABLE_NAME = '{$tabela}';";
        return $this->fetch($sql);
    }

    public function datumi()
    {
        $sql = "SELECT * FROM {$this->table} WHERE pretraga = 1 AND (tip = 'date' OR tip = 'time' OR tip = 'timestamp');";
        return $this->fetch($sql);
    }

    public function brojke()
    {
        $sql = "SELECT * FROM {$this->table} WHERE pretraga = 1 AND (tip = 'decimal' OR tip = 'int');";
        return $this->fetch($sql);
    }

    public function zaSanitaciju()
    {
        $sql = "SELECT naziv FROM {$this->table} WHERE pretraga = 1 AND (tip = 'varchar' OR tip = 'text' OR tip = 'enum');";
        return $this->fetch($sql);
    }

    public function refet()
    {
        $sql = "SELECT * FROM {$this->table} WHERE pretraga = 1 AND ref_tabela IS NOT NULL;";
        return $this->fetch($sql);
    }

    public function pretraga()
    {
        $sql = "SELECT * FROM {$this->table} WHERE pretraga = 1;";
        return $this->fetch($sql);
    }

    public function validacija()
    {
        $sql = "SELECT * FROM {$this->table} WHERE validacija = 1;";
        return $this->fetch($sql);
    }

    public function log()
    {
        $sql = "SELECT * FROM {$this->table} WHERE log = 1;";
        return $this->fetch($sql);
    }
    public function sortiranje()
    {
        $sql = "SELECT * FROM {$this->table} WHERE sortiranje = 1;";
        return $this->fetch($sql);
    }
}
