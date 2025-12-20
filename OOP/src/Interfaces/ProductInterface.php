<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ProductInterface
{
    public function getPrice(): float;
    public function getName(): string;
    public function getDescription(): string;
}
