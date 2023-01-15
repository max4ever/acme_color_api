<?php declare(strict_types=1);

namespace Acme\ColorApi\Validator;

use Acme\ColorApi\Entity\Color;

trait ColorValidatorTrait
{
    public function validate(Color $color): array
    {
        $errors = [];

        if (empty($color->getName()) || strlen($color->getName()) < 2) {
            $errors[] = 'Color name must have at least 2 characters';
        } else if (strlen($color->getName()) > 40) {
            $errors[] = 'Color name must be shorter than 50';
        }

        if (!ctype_xdigit($color->getHexValue()) || strlen($color->getHexValue()) !== 6) {
            $errors[] = 'Color hex value is not valid';
        }
        return $errors ? ['errors' => $errors] : $errors;
    }
}
