<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->decimal('price');
            $table->integer('qty');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
        DB::table('products')->insert([
            [
                'name' => 'Elma',
                'description' => 'Amasya elması taptaze',
                'price' => '50.00',
                'qty' => 25,
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
