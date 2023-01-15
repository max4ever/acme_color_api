<?php

namespace Tests\Entity;

use Acme\ColorApi\Entity\Color;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{
    public function testGetters(): void
    {
        $colorEntity = new Color('red', 'FFAABB', 1);
        self::assertEquals(1, $colorEntity->getId());
        self::assertEquals('red', $colorEntity->getName());
        self::assertEquals('FFAABB', $colorEntity->getHexValue());
    }

    public function testNullId(): void
    {
        $colorEntity = new Color('red', 'FFAABB');
        self::assertEquals(null, $colorEntity->getId());
        self::assertEquals('red', $colorEntity->getName());
        self::assertEquals('FFAABB', $colorEntity->getHexValue());
    }
}
