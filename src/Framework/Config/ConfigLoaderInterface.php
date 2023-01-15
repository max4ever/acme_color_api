<?php

namespace Acme\ColorApi\Framework\Config;

interface ConfigLoaderInterface
{
    public function getConfig(): array;
}
