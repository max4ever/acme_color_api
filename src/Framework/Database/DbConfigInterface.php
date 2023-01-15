<?php declare(strict_types=1);

namespace Acme\ColorApi\Framework\Database;

interface DbConfigInterface
{
    public function getHostName(): string;

    public function getPortNumber(): int;

    public function getUsername(): string;

    public function getPassword(): string;

    public function getDbName(): string;
}
