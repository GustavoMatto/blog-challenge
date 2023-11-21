<?php

namespace Desafiobis2bis\App\Model\Config;

class Database
{
    const HOST = 'mysql';
    const PORT = '3306';
    const DBNAME = 'blogdatabase';
    const USERNAME = 'gustavo';
    const PASSWORD = 'admin';

    public function connection()
    {
        try {
            $db = new PDO("mysql:host=" . self::HOST . ";port=" . self::PORT . ";dbname=" . self::DBNAME, self::USERNAME, self::PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->createUserTable($db);
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }

        return $db;
    }

    public function createUserTable($db)
    {
        $tableExists = $db->query("SHOW TABLES LIKE 'users'")->rowCount() > 0;

        if (!$tableExists) {
            $db->exec("
                CREATE TABLE users (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    username VARCHAR(255) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL
                )
            ");
        }
    }
}
