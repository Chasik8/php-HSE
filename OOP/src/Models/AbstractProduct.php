<?php

declare(strict_types=1);

namespace App\Models;

use App\Interfaces\ProductInterface;
use App\Traits\LoggerTrait;

abstract class AbstractProduct implements ProductInterface
{
    use LoggerTrait;

    protected string $name;
    protected float $price;
    protected string $currency;

    protected string $temporaryCache = 'Some cached data';

    public function __construct(string $name, float $price, string $currency = 'USD')
    {
        if ($price < 0) {
            throw new \InvalidArgumentException("Price cannot be negative.");
        }

        $this->name = $name;
        $this->price = $price;
        $this->currency = $currency;

        $this->log("Created product: {$this->name}");
    }

    public function __destruct()
    {
        $this->log("Destructor called for: {$this->name}");
    }

    public function __toString(): string
    {
        return sprintf("%s (Price: %.2f %s)", $this->name, $this->price, $this->currency);
    }

    public function __debugInfo(): array
    {
        return [
            'name' => $this->name,
            'price_formatted' => $this->price . ' ' . $this->currency,
            'info' => 'This is a secure debug view (internal cache hidden)'
        ];
    }

    public function __clone()
    {
        $this->name = "Copy of " . $this->name;
        $this->log("Object cloned. New name: {$this->name}");
    }

    public function __sleep(): array
    {
        return ['name', 'price', 'currency'];
    }

    public function __wakeup(): void
    {
        $this->temporaryCache = 'Restored cache data';
        $this->log("Object woke up from serialization: {$this->name}");
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract public function calculateDeliveryCost(): float;

    abstract public function getTypeDetails(): string;
}