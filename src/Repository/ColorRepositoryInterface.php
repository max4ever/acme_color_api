<?php

namespace Acme\ColorApi\Repository;

use Acme\ColorApi\Entity\Color;

interface ColorRepositoryInterface
{
    public function getColor(int $id): Color;

    public function findAll(): array;

    public function delete(int $id): int;

    public function insert(Color $color): int;
}
