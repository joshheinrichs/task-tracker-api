<?php

class Db
{
    private static $instance = NULL;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * Returns a connection to the database.
     * @return mysqli|null
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $ini_array = parse_ini_file("../config.ini");
            self::$instance = new mysqli($ini_array['host'], $ini_array['username'], $ini_array['password'], $ini_array['dbname']);
        }
        return self::$instance;
    }
}