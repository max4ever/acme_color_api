<?php declare(strict_types=1);

namespace Acme\ColorApi\Framework\Config;

use InvalidArgumentException;

class IniConfigLoader implements ConfigLoaderInterface
{
    private string $configFile;
    private array $config = [];

    public function __construct(string $configFilename)
    {
        $this->configFile = $configFilename;
    }

    /**
     * @throws ConfigException
     */
    public function getConfig(): array
    {
        if (empty($this->config)) {
            $this->loadConfig($this->configFile);
        }

        return $this->config;
    }

    /**
     * @throws ConfigException
     */
    private function loadConfig(string $configFilename): void
    {
        if (!is_file($configFilename)) {
            throw new InvalidArgumentException('Config file ' . $configFilename . ' not found');
        }

        $result = parse_ini_file($configFilename, true);
        if (!is_array($result)) {
            throw new ConfigException('Failed loading config file ' . $configFilename);
        }
        $this->config = $result;
    }
}
