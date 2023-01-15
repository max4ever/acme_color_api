<?php declare(strict_types=1);

namespace Acme\ColorApi\Framework\Database;

use PDO;

class MysqlConnection implements DbConnectionInterface
{

    private PDO $instance;
    private DbConfigInterface $config;

    public function __construct(DbConfigInterface $config)
    {
        $this->config = $config;
    }

    public function getInstance(): PDO
    {
        if (empty($this->instance)) {
            $db = new \PDO('mysql:host='.$this->config->getHostName().';dbname='.$this->config->getDbName().';charset=utf8',
                $this->config->getUsername(),
                $this->config->getPassword(),
                [
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->instance = $db;
        }

        return $this->instance;
    }

}
