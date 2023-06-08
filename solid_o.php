<?php

class SomeObject
{
    protected $name;

    public function __construct(string $name) {}

    public function getObjectName(): string {}
}

interface HandlerInterface
{
    /**
     * @param SomeObject[] $objects
     * @return array
     */
    public function handleObjects(array $objects): array;
}

class SomeObjectsHandler implements HandlerInterface
{
    public function __construct() {}

    /**
     * @param SomeObject[] $objects
     * @return array
     */
    public function handleObjects(array $objects): array
    {
        $handlers = [];
        foreach ($objects as $object) {
            $handler = $this->handle($object->getObjectName());
            if ($handler !== null) {
                $handlers[] = $handler;
            }
        }

        return $handlers;
    }

    protected function handle(string $name): ?string
    {
        // в целом реализовать действие можно как угодно, главное, чтобы не трогали
        return match ($name) {
            'object_1' => 'handle_object_1',
            'object_2' => 'handle_object_2',
            default => null,
        };
    }
}

$objects = [
    new SomeObject('object_1'),
    new SomeObject('object_2')
];

$soh = new SomeObjectsHandler();
$soh->handleObjects($objects);