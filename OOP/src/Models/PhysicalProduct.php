<?php

declare(strict_types=1);

namespace App\Models;

final class PhysicalProduct extends AbstractProduct
{
    private float $weightKg;

    public function __construct(string $name, float $price, float $weightKg)
    {
        parent::__construct($name, $price);
        $this->weightKg = $weightKg;
    }

    public function calculateDeliveryCost(): float
    {
        return $this->weightKg * 10.0;
    }

    public function getDescription(): string
    {
        return "Physical Item: {$this->name}, Weight: {$this->weightKg}kg";
    }

    public function getTypeDetails(): string
    {
        return "Requires shipping container.";
    }
}