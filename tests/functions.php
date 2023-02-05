<?php

declare(strict_types=1);

/**
 * Call non-accessible method
 * @param object $object
 * @param string $method
 * @param array $args
 * @return mixed
 * @throws ReflectionException
 */
function call_private_method(object $object, string $method, array $args = []): mixed
{
    $class = new ReflectionClass($object);
    $method = $class->getMethod($method);
    $method->setAccessible(true);
    return $method->invokeArgs($object, $args);
}

/**
 * update non-accessible property
 * @param object $object
 * @param string $property
 * @param mixed $value
 * @return void
 * @throws ReflectionException
 */
function update_private_property(object $object, string $property, mixed $value): void
{
    $class = new ReflectionClass($object);
    $property = $class->getProperty($property);
    $property->setAccessible(true);
    $property->setValue($object, $value);
}