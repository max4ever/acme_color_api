<?php declare(strict_types=1);

namespace Acme\ColorApi\Controller\Action\Color;

use Acme\ColorApi\Controller\Action\AbstractCrudAction;
use Acme\ColorApi\Entity\Color;
use Acme\ColorApi\Validator\ColorValidatorTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostColorAction extends AbstractCrudAction
{
    use ColorValidatorTrait;

    public function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getParsedBody();
        if (!isset($params['name'], $params['hexValue'])) {
            return $this->getHttpResponse(400);
        }

        $color = new Color($params['name'], $params['hexValue']);
        $errors = $this->validate($color);
        if (!empty($errors)) {
            return $this->getJsonResponse(400, $errors);
        }

        $id = $this->colorRepository->insert($color);
        return $this->getJsonResponse(201, (new Color($color->getName(), $color->getHexValue(), $id))->toArray());
    }
}
