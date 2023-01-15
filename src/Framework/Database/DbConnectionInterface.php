<?php

namespace Acme\ColorApi\Framework\Database;

use PDO;

interface DbConnectionInterface
{
    public function getInstance(): PDO;
}
