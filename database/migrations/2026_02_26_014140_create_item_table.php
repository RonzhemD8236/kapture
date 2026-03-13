<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->id('item_id');
            $table->string('title');
            $table->string('category');
            $table->text('description');
            $table->decimal('cost_price', 8, 2);
            $table->decimal('sell_price', 8, 2);
            $table->string('img_path')->default('default.jpg');
            $table->text('images')->nullable();
            $table->timestamps();
            $table->softDeletes(); // ← add this
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item');
    }
};