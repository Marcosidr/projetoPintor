<?php
namespace App\Core;
use PDO; use PDOException;

class Database {
    private static ?PDO $conn = null;

    public static function connection(): PDO {
        if (self::$conn) return self::$conn;
        $host = Env::get('DB_HOST','localhost');
        $db   = Env::get('DB_NAME','CLPinturas');
        $user = Env::get('DB_USER','root');
        $pass = Env::get('DB_PASS','');
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC];
        try { self::$conn = new PDO($dsn,$user,$pass,$opt); } catch(PDOException $e){
            throw new \RuntimeException('Erro conexão banco: '.$e->getMessage());
        }
        return self::$conn;
    }
}
