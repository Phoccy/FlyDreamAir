<?php
declare(strict_types=1);

namespace Sys\Core;

use Sys\Library\Database;

abstract class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}