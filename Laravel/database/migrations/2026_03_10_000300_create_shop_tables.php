<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'full_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('full_name')->nullable()->after('id');
            });
        }

        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('customer')->after('password');
            });
        }

        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2);
                $table->string('image_url')->nullable();
                $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_number')->unique();
                $table->timestamp('order_date');
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->decimal('total', 10, 2);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->unsignedInteger('quantity');
                $table->decimal('price', 10, 2);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('ratings')) {
            Schema::create('ratings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->unsignedTinyInteger('rating');
                $table->text('comment')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('feedback')) {
            Schema::create('feedback', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->text('message');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('feedback')) {
            Schema::dropIfExists('feedback');
        }

        if (Schema::hasTable('ratings')) {
            Schema::dropIfExists('ratings');
        }

        if (Schema::hasTable('order_items')) {
            Schema::dropIfExists('order_items');
        }

        if (Schema::hasTable('orders')) {
            Schema::dropIfExists('orders');
        }

        if (Schema::hasTable('products')) {
            Schema::dropIfExists('products');
        }

        if (Schema::hasTable('categories')) {
            Schema::dropIfExists('categories');
        }

        if (Schema::hasColumn('users', 'full_name') || Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'full_name')) {
                    $table->dropColumn('full_name');
                }
                if (Schema::hasColumn('users', 'role')) {
                    $table->dropColumn('role');
                }
            });
        }
    }
};

