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
            $db = new \PDO("mysql:host=" . self::HOST . ";port=" . self::PORT . ";dbname=" . self::DBNAME, self::USERNAME, self::PASSWORD);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            if ($db->query("SHOW TABLES LIKE 'users'")->rowCount() < 1) {
                $this->createUserTable($db);
            }

            if ($db->query("SHOW TABLES LIKE 'posts'")->rowCount() < 1) {
                $this->createPostTable($db);
            }

        } catch (\PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }

        return $db;
    }

    public function createUserTable($db)
    {
        $db->exec("CREATE TABLE users (
                id INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(255) DEFAULT 'Default' NOT NULL)
            ");
    }

    public function createPostTable($db)
    {
        $db->exec("CREATE TABLE posts (
                id INT PRIMARY KEY AUTO_INCREMENT,
                content VARCHAR(255) NOT NULL,
                title VARCHAR(255) NOT NULL)
            ");
    }

    public function generateDatabaseDump()
    {
        try {
            $dumpFilePath = './MysqlDump/dump.sql';
    
            $port = '8002';
            $host = '127.0.0.1';
            $user = 'root';
            $password = 'admin123';
    
            $command = sprintf(
                "mysqldump -h%s -P%s -u%s --password=%s blogdatabase > %s",
                $host,
                $port,
                $user,
                $password,
                $dumpFilePath
            );
    
            exec($command, $output, $returnValue);
            if ($returnValue === 0) {
                return true;
            }
        } catch (\Exception $e) {
            die("Erro ao gerar o dump do banco de dados: " . $e->getMessage());
        }
    }

    public function getPropertyFromDatabase($userId, $property)
    {
        $db = $this->connection();
        $stmt = $db->prepare("SELECT $property FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ? $result[$property] : null;
    }

    public function setPropertyInDatabase($userId, $property, $newValue)
    {
        $db = $this->connection();
        $stmt = $db->prepare("UPDATE users SET $property = ? WHERE id = ?");
        $stmt->execute([$newValue, $userId]);
    }

    public function executeStatement($sql, $parameters = []): \PDOStatement
    {
        try {
            $db = $this->connection();

            $stmt = $db->prepare($sql);
            $stmt->execute($parameters);

            return $stmt;
        } catch (\PDOException $e) {
            die("Erro ao executar consulta: " . $e->getMessage());
        }
    }
}
