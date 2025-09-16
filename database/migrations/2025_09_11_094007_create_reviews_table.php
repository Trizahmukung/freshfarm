<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_reviews_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Ensures a review is tied to a valid purchase
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('farm_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating'); // e.g., 1-5
            $table->text('comment')->nullable();
            $table->timestamps();

            // Prevent a user from reviewing the same product in the same order multiple times
            $table->unique(['order_id', 'product_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};