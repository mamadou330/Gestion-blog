<?php

namespace App;

use App\Connection;
use \PDO;
use App\URL;

class PaginatedQuery
{
    private $query;
    private $queryCount;
    private $pdo;
    private $perPage;
    private $count;
    private $items;

    public function __construct(
        string $query,
        string $queryCount,
        ?PDO $pdo = null,
        int $perPage = 12
    ) 
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->perPage = $perPage;
    }

    public function getItems(string $classMapping): array
    {
        dump("Je suis cool");
        if($this->items === null) {
            $currentPage = $this->getCurrentPage();
            $pages = $this->getPages();
            if ($currentPage > $pages) {
                throw new \Exception("Cette Page n'existe pas");
            }
            $offset = $this->perPage * ($currentPage - 1);
            $this->items =  $this->pdo->query(
                $this->query .
                " LIMIT {$this->perPage} OFFSET $offset")
                ->fetchAll(PDO::FETCH_CLASS, $classMapping);
        }
        return $this->items;
    }

    public function previousLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        if ($currentPage <= 1)
            return null;
        if ($currentPage > 2)
            $link .= "?page=" . ($currentPage - 1);
        return <<<HTML
            <a href="{$link}" class="btn btn-primary">&laquo; Page Précédent</a>
HTML;
    }

    public function nextLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if ($currentPage >= $pages)
            return null;
        $link .= "?page=" . ($currentPage + 1);
        return <<<HTML
            <a href="{$link}" class="btn btn-primary ml-auto">Page Suivant &raquo;</a>
HTML;
    }

    private function getCurrentPage(): int
    {
        return URL::getPositiveInt('page', 1);
    }

    private function getPages(): int
    {
        if ($this->count === null) {
            $this->count = (int) $this->pdo
                ->query($this->queryCount)
                ->fetch(PDO::FETCH_NUM)[0];
        }
        return ceil($this->count / $this->perPage); //nombre de pages = nombres d'articles / nbres d'article par pages

    }
}
