<?php

namespace SavvytechTask\Infrastructure\Commands;

use DirectoryIterator;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use SavvytechTask\Infrastructure\Commands\Contracts\Command;
use SavvytechTask\Infrastructure\Commands\Contracts\CommandManagerInterface;

class CommandManager implements CommandManagerInterface
{
    protected string $commandsNamespace = 'SavvytechTask\Commands';

    /**
     * @throws ReflectionException
     */
    public function makeCommand(string $command): mixed
    {
        $files = $this->getCommandFiles();

        foreach ($files as $file) {
            if ($this->checkCommandFileFormat($file)) {
                require_once $file->getPathname();
                $className = $this->commandsNamespace . '\\' . $file->getBasename('.php');
                $reflectionClass = new ReflectionClass($className);

                if ($reflectionClass->implementsInterface(Command::class)) {
                    $properties = $reflectionClass->getDefaultProperties();
                    if (isset($properties['signature']) && strtolower($properties['signature']) === strtolower($command)) {
                        return new $className();
                    }
                }
            }
        }

        throw new InvalidArgumentException("Command not found for $command");
    }

    /**
     * @return DirectoryIterator
     */
    private function getCommandFiles(): DirectoryIterator
    {
        return new DirectoryIterator(__DIR__ . '/../../Commands');
    }

    /**
     * @param $file
     * @return bool
     */
    private function checkCommandFileFormat($file): bool
    {
        return !$file->isDot() && $file->isFile() && $file->getExtension() === 'php';
    }
}