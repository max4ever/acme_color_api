<?php declare(strict_types=1);

namespace Acme\ColorApi\Repository;

use Acme\ColorApi\Entity\Color;
use PDO;

class ColorRepository implements ColorRepositoryInterface
{

    private PDO $pdo;

    public function __construct(PDO $dbConnection)
    {
        $this->pdo = $dbConnection;
    }

    public function getColor(int $id): Color
    {
        $statement = $this->pdo->prepare('SELECT * FROM `color` WHERE id = :id');
        $statement->bindParam('id', $id);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            throw new NotFoundException('Row was not found in the db for id = ' . $id);
        }
        return new Color($result['name'], $result['hexValue'], $result['id']);
    }

    public function findAll(): array
    {
        $statement = $this->pdo->query('SELECT * FROM `color`');
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $colors = [];
        foreach ($result as $row) {
            $colors[] = new Color($row['name'], $row['hexValue'], $row['id']);
        }

        return $colors;
    }

    public function delete(int $id): int
    {
        $statement = $this->pdo->prepare('DELETE FROM `color` WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);

        return $statement->rowCount();
    }

    public function insert(Color $color): int
    {
        $statement = $this->pdo->prepare('INSERT INTO `color` (`name`, `hexValue`) VALUES (:name, :hexValue)');
        $statement->execute(['name' => $color->getName(), 'hexValue' => $color->getHexValue()]);

        $id = $this->pdo->lastInsertId();
        if ($id === false) {
            throw new \PDOException('Error inserting new color in the database');
        }

        return (int)$id;
    }
}
