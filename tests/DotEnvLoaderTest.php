<?php

declare(strict_types=1);

namespace Tomrf\DotEnv\Test;

use PHPUnit\Framework\TestCase;
use Tomrf\DotEnv\DotEnvLoader;
use Tomrf\DotEnv\DotEnvLoaderException;

/**
 * @internal
 * @covers \Tomrf\DotEnv\DotEnvLoader
 * @covers \Tomrf\DotEnv\DotEnvLoaderException
 */
final class DotEnvLoaderTest extends TestCase
{
    public function testDotEnvLoaderIsInstanceOfDotEnvLoader(): void
    {
        static::assertInstanceOf(DotEnvLoader::class, new DotEnvLoader());
    }

    public function testLoad(): void
    {
        $dotEnvLoader = new DotEnvLoader();
        $dotEnvLoader->load('tests/dotfiles/valid_dotenv_1');

        static::assertSame('abc123', $_ENV['TESTVAR1']);
        static::assertSame(1024, $_ENV['TESTVAR2']);
        static::assertSame(1, $_ENV['TESTVAR3']);
        static::assertTrue($_ENV['TESTVAR4']);
        static::assertTrue($_ENV['TESTVAR5']);
        static::assertTrue($_ENV['TESTVAR6']);
        static::assertFalse($_ENV['TESTVAR7']);
        static::assertFalse($_ENV['TESTVAR8']);
        static::assertFalse($_ENV['TESTVAR9']);
        static::assertNull($_ENV['TESTVAR0']);
    }

    public function testLoadImmutable(): void
    {
        $_ENV['TESTVAR2'] = 2048;
        $_ENV['TESTVAR0'] = 'not null';

        $dotEnvLoader = new DotEnvLoader();
        $dotEnvLoader->loadImmutable('tests/dotfiles/valid_dotenv_1');

        static::assertSame('abc123', $_ENV['TESTVAR1']);
        static::assertSame(1, $_ENV['TESTVAR3']);
        static::assertTrue($_ENV['TESTVAR4']);
        static::assertTrue($_ENV['TESTVAR5']);
        static::assertTrue($_ENV['TESTVAR6']);
        static::assertFalse($_ENV['TESTVAR7']);
        static::assertFalse($_ENV['TESTVAR8']);
        static::assertFalse($_ENV['TESTVAR9']);

        static::assertSame(2048, $_ENV['TESTVAR2']);
        static::assertSame('not null', $_ENV['TESTVAR0']);
    }

    public function testLoadingIgnoredDotEnv(): void
    {
        $dotEnvLoader = new DotEnvLoader();
        $dotEnvLoader->load('tests/dotfiles/valid_dotenv_ignored');

        static::assertNull($_ENV['IGNOREDVAR'] ?? null);
    }

    public function testLoadingNonExistentFileThrowsException(): void
    {
        $this->expectException(DotEnvLoaderException::class);

        $dotEnvLoader = new DotEnvLoader();
        $dotEnvLoader->load('tests/no_such_file');
    }

    public function testLoadingInvalidDotEnvFileNo1ThrowsException(): void
    {
        $this->expectException(DotEnvLoaderException::class);

        $dotEnvLoader = new DotEnvLoader();
        $dotEnvLoader->load('tests/dotfiles/invalid_dotenv_1');
    }

    public function testLoadingInvalidDotEnvFileNo2ThrowsException(): void
    {
        $this->expectException(DotEnvLoaderException::class);

        $dotEnvLoader = new DotEnvLoader();
        $dotEnvLoader->load('tests/dotfiles/invalid_dotenv_2');
    }

    public function testLoadingEmptyStringThrowsException(): void
    {
        $this->expectException(DotEnvLoaderException::class);

        $dotEnvLoader = new DotEnvLoader();
        $dotEnvLoader->load('');
    }
}
