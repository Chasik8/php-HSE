<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\PhysicalProduct;
use App\Models\DigitalProduct;
use App\Models\Cart;

$couponValidator = new class {
    public function isValid(string $code): bool
    {
        return $code === 'SALE2024';
    }
};

echo "=== STARTING SHOP DEMO ===" . PHP_EOL;

try {
    $iphone = new PhysicalProduct("iPhone 15", 999.00, 0.5);
    $ebook = new DigitalProduct("PHP OOP Guide", 29.99, 15.0);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo "\n--- Product Info (Inheritance & Polymorphism) ---" . PHP_EOL;
echo $iphone->getDescription() . " | Delivery: $" . $iphone->calculateDeliveryCost() . PHP_EOL;
echo $ebook->getDescription() . " | Delivery: $" . $ebook->calculateDeliveryCost() . PHP_EOL;

echo "\n--- Magic Methods (__toString) ---" . PHP_EOL;
echo "String representation: " . $iphone . PHP_EOL;

echo "\n--- Magic Methods (__debugInfo) ---" . PHP_EOL;
var_dump($iphone);

echo "\n--- Cloning ---" . PHP_EOL;
$iphoneClone = clone $iphone;
echo "Original: " . $iphone->getName() . PHP_EOL;
echo "Clone: " . $iphoneClone->getName() . PHP_EOL;

echo "\n--- Serialization ---" . PHP_EOL;
$serialized = serialize($ebook);
echo "Serialized: " . $serialized . PHP_EOL;
$unserializedEbook = unserialize($serialized);
echo "Unserialized Name: " . $unserializedEbook->getName() . PHP_EOL;

echo "\n--- Anonymous Class Check ---" . PHP_EOL;
$code = 'SALE2024';
echo "Coupon '$code' valid? " . ($couponValidator->isValid($code) ? 'Yes' : 'No') . PHP_EOL;

echo "\n--- Shopping Cart ---" . PHP_EOL;
$cart = new Cart();
$cart->add($iphone);
$cart->add($ebook);
echo "Total Cart Price: $" . $cart->getTotal() . PHP_EOL;

echo "\n=== END OF DEMO ===" . PHP_EOL;
