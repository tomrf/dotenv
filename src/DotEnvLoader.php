<?php

declare(strict_types=1);

namespace Tomrf\DotEnv;

use Exception;

/**
 * Simple dotenv loader using parse_ini_file().
 *
 * @SuppressWarnings("global")
 */
class DotEnvLoader
{
    /**
     * Loads dotenv file into local environment, overwriting any environment
     * variable already set.
     */
    public function load(string $filename): void
    {
        $env = $this->parseAsIniFile($filename);

        foreach ($env as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Loads dotenv file into local environment while preserving any existing
     * environment variable.
     */
    public function loadImmutable(string $filename): void
    {
        $env = $this->parseAsIniFile($filename);

        foreach ($env as $key => $value) {
            if (isset($_ENV[$key])) {
                continue;
            }

            $this->set($key, $value);
        }
    }

    /**
     * Sets environment variable.
     */
    private function set(string $key, mixed $value): void
    {
        $_ENV[$key] = $value;
    }

    /**
     * Parses dotenv file using parse_ini_file() with INI_SCANNER_TYPED
     * scanner mode.
     *
     * @throws DotEnvLoaderException
     *
     * @return array<string,null|bool|int|string>
     */
    private function parseAsIniFile(string $filename): array
    {
        if (!file_exists($filename)) {
            throw new DotEnvLoaderException(sprintf(
                'Error parsing dotenv file: file not found: "%s"',
                $filename
            ));
        }

        try {
            $env = parse_ini_file($filename, false, INI_SCANNER_TYPED);
        } catch (Exception $exception) {
            throw new DotEnvLoaderException(sprintf(
                'Error parsing dotenv file: %s',
                $exception
            ));
        }

        if (\is_bool($env)) {
            throw new DotEnvLoaderException(sprintf(
                'Error parsing dotenv file: parse_ini_file returned false for "%s"',
                $filename
            ));
        }

        return $env;
    }
}
