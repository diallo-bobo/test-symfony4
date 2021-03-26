<?php

namespace App\Tests;

use Symfony\Component\Validator\ConstraintViolation;

/**
 * @template E
 * Trait ToolsTrait
 * @package App\Tests
 */
trait ToolsTrait
{
    /**
     * @param E $entity
     * @param int $numbers
     */
    public function assertHasErrors($entity, int $numbers = 0): void
    {
        $errors = static::$container->get('validator')->validate($entity);
        $messages = [];

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }

        $this->assertCount($numbers, $errors, implode(',', $messages));
    }
}
