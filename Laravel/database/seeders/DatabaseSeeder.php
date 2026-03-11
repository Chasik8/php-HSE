<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'full_name' => 'Администратор',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $customer = User::factory()->create([
            'name' => 'Buyer',
            'full_name' => 'Покупатель',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $electronics = Category::create([
            'name' => 'Электроника',
            'description' => 'Электронные устройства и техника',
            'parent_id' => null,
        ]);

        $monitors = Category::create([
            'name' => 'Мониторы',
            'description' => 'Компьютерные мониторы',
            'parent_id' => $electronics->id,
        ]);

        $laptops = Category::create([
            'name' => 'Ноутбуки',
            'description' => 'Портативные компьютеры',
            'parent_id' => $electronics->id,
        ]);

        $smartphones = Category::create([
            'name' => 'Смартфоны',
            'description' => 'Современные смартфоны и телефоны',
            'parent_id' => $electronics->id,
        ]);

        $accessories = Category::create([
            'name' => 'Аксессуары',
            'description' => 'Кабели, мыши, клавиатуры и другая периферия',
            'parent_id' => $electronics->id,
        ]);

        $monitorProduct = Product::create([
            'name' => 'Монитор 24\" Full HD',
            'description' => '24-дюймовый монитор с разрешением 1920x1080 и частотой 75 Гц.',
            'price' => 12990,
            'image_url' => null,
            'category_id' => $monitors->id,
        ]);

        $gamingMonitor = Product::create([
            'name' => 'Игровой монитор 27\" 144 Гц',
            'description' => 'Игровой монитор с высоким разрешением и частотой 144 Гц.',
            'price' => 27990,
            'image_url' => null,
            'category_id' => $monitors->id,
        ]);

        $laptopProduct = Product::create([
            'name' => 'Ноутбук 15\" Core i5',
            'description' => 'Универсальный ноутбук с процессором Intel Core i5 и 16 ГБ ОЗУ.',
            'price' => 65990,
            'image_url' => null,
            'category_id' => $laptops->id,
        ]);

        $ultrabook = Product::create([
            'name' => 'Ультрабук 14\" Core i7',
            'description' => 'Лёгкий ультрабук для работы и учёбы.',
            'price' => 89990,
            'image_url' => null,
            'category_id' => $laptops->id,
        ]);

        $smartphone = Product::create([
            'name' => 'Смартфон 6.5\" OLED',
            'description' => 'Смартфон с OLED-экраном и поддержкой 5G.',
            'price' => 49990,
            'image_url' => null,
            'category_id' => $smartphones->id,
        ]);

        $mouse = Product::create([
            'name' => 'Беспроводная мышь',
            'description' => 'Удобная беспроводная мышь для работы и игр.',
            'price' => 1990,
            'image_url' => null,
            'category_id' => $accessories->id,
        ]);

        $order = Order::create([
            'order_number' => 'ORD-' . Str::upper(Str::random(8)),
            'order_date' => now(),
            'user_id' => $customer->id,
            'total' => $monitorProduct->price + $laptopProduct->price,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $monitorProduct->id,
            'quantity' => 1,
            'price' => $monitorProduct->price,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $laptopProduct->id,
            'quantity' => 1,
            'price' => $laptopProduct->price,
        ]);

        Rating::create([
            'user_id' => $customer->id,
            'product_id' => $monitorProduct->id,
            'rating' => 5,
            'comment' => 'Отличный монитор, яркий и с хорошими углами обзора.',
        ]);

        Feedback::create([
            'user_id' => $customer->id,
            'name' => $customer->full_name,
            'email' => $customer->email,
            'message' => 'Здравствуйте! Подскажите, когда ожидается поступление новых моделей ноутбуков?',
        ]);
    }
}
