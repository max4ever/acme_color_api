<?php declare(strict_types=1);

namespace Acme\ColorApi\Entity;

/**
 * Plain old class for data transfer
 */
class Color implements EntityInterface
{
    private ?int $id;
    private string $name;
    private string $hexValue;

    public function __construct(string $name, string $hexValue, ?int $id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->hexValue = $hexValue;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHexValue(): string
    {
        return $this->hexValue;
    }

    public function toArray(): array
    {
        return ['id' => $this->id, 'name' => $this->name, 'hexValue' => $this->hexValue];
    }

}
