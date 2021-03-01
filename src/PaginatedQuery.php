<?php 
namespace App;

use App\Connection;

class PaginatedQuery 
{
    private $query;
    private $queryCount;
    private $classMapping;
    private $pdo;
    private $perPage;

    public function __construct(
        string $query,
        string $queryCount,
        string $classMapping,
        ?\PDO $pdo,
        int $perPage = 12
    )
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->classMapping = $classMapping;
        $this->pdo = $pdo ?:Connection::getPDO();
        $this->perPage = $perPage;
    }
}