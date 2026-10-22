<?php
 
class DatabaseConnection
{
    private static $connection = null;
 
    private function __construct() {}
 
    public static function getConnection()
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=localhost;dbname=toko_merch_band;charset=utf8",
                    "root",
                    ""
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Koneksi gagal! " . $e->getMessage());
            }
        }
 
        return self::$connection;
    }
}