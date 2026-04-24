<?php
declare(strict_types=1);

namespace Sys\Library;

use PDO;
use PDOException;
use PDOStatement;
use RuntimeException;

final class Database
{
    private ?PDO $instance = null;
    private string $host = 'localhost';
    private string $dbName = 'flydreamair_db';
    private string $username = 'flydreamair_admin';
    private string $password = 'flydreamair_p455';
    private string $charset = 'utf8mb4';

    public function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset={$this->charset}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->instance = new PDO($dsn, $this->username, $this->password, $options);            
        } catch (PDOException $e) {
            throw new RuntimeException("Database Connection Error: " . $e->getMessage());
        }
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            new self();
        }

        return self::$instance;
    }

    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->instance->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();        
    }
}