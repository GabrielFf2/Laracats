<?php

namespace dao;

use Core\App;
use Core\Database;

class DAOFactory
{
    private static $database;
    public function __construct()
    {
        if (self::$database === null) {
            self::$database = App::resolve(Database::class);
        }
        return self::$database;
    }
    public function getNoteDAO()
    {
        return new notesDao(self::$database);
    }

}
