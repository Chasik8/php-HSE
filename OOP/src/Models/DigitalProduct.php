<?php

declare(strict_types=1);

namespace App\Models;

class DigitalProduct extends AbstractProduct
{
    private float $fileSizeMb;

    public function __construct(string $name, float $price, float $fileSizeMb)
    {
        parent::__construct($name, $price);
        $this->fileSizeMb = $fileSizeMb;
    }

    public function calculateDeliveryCost(): float
    {
        return 0.0;
    }

    public function getDescription(): string
    {
        return "Digital Download: {$this->name}, Size: {$this->fileSizeMb}MB";
    }

    public function getTypeDetails(): string
    {
        return "Sent via email link.";
    }
}
