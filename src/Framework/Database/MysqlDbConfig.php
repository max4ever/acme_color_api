<?php declare(strict_types=1);

namespace Acme\ColorApi\Framework\Database;

use Acme\ColorApi\Framework\Config\ConfigLoaderInterface;
use OutOfBoundsException;

class MysqlDbConfig implements DbConfigInterface
{
    private array $config;

    public function __construct(ConfigLoaderInterface $configFileLoader)
    {
        $params = $configFileLoader->getConfig();

        if (empty($params['mysql'])) {
            throw new OutOfBoundsException('Config params for mysql not found');
        }

        $mysqlConfig = $params['mysql'];
        if (!isset($mysqlConfig['host'], $mysqlConfig['port'], $mysqlConfig['username'], $mysqlConfig['password'], $mysqlConfig['dbname'])) {
            throw new \InvalidArgumentException('Some required config params are missing');
        }
        $this->config = $mysqlConfig;
    }

    public function getHostName(): string
    {
        return $this->config['host'];
    }

    public function getPortNumber(): int
    {
        return $this->config['port'];
    }

    public function getUsername(): string
    {
        return $this->config['username'];
    }

    public function getPassword(): string
    {
        return $this->config['password'];
    }

    public function getDbName(): string
    {
        return $this->config['dbname'];
    }
}
