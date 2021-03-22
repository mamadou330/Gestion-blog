<?php
namespace App\Table\Exceptions;

class NotFoundException extends \Exception
{
    public function __construct(string $table, $id)
    {
        $this->message = "Aucun enregistrement ne correpond à l'id #$id dans la table '$table'";
    }
}