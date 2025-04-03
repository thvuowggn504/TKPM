<<<<<<< HEAD
<?php
require_once 'config.php';
class Database
{
    public static $connection;
    public function __construct()
    {
        if (!self::$connection) {
            self::$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            self::$connection->set_charset(DB_CHARSET);
        }
        return self::$connection;
    }
}
=======
<?php
require_once 'config.php';
class Database {
    private static $conn;

    public static function getConnection() {
        if (!self::$conn) {
            self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if (self::$conn->connect_error) {
                die("Kết nối thất bại: " . self::$conn->connect_error);
            }
            self::$conn->set_charset(DB_CHARSET);
        }
        return self::$conn;
    }
}
>>>>>>> 0303bbfa776af79f2236cdc5a350d409aa44073d
?>