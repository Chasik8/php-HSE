<?php

declare(strict_types=1);

namespace App\Models;

use App\Interfaces\ProductInterface;

class Cart
{
    private array $items = [];

    public function add(ProductInterface $product): void
    {
        $this->items[] = $product;
    }

    public function getTotal(): float
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item->getPrice();
        }
        return $sum;
    }
}