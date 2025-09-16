<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // A friendly unique ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The consumer
            $table->foreignId('farm_id')->constrained()->onDelete('cascade');

            $table->enum('status', [
                'pending',    // Order placed, payment pending
                'confirmed',  // Farmer has seen and accepted the order
                'processing', // Farmer is harvesting/packing
                'ready',      // Order is ready for pickup/delivery
                'dispatched', // Order is out for delivery
                'delivered',  // Order is completed
                'cancelled'   // Order was cancelled
            ])->default('pending');

            $table->text('notes')->nullable(); // Notes from the consumer
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);

            // Delivery Information
            $table->enum('fulfillment_method', ['pickup', 'delivery'])->default('pickup');
            $table->text('delivery_address')->nullable();
            $table->decimal('delivery_lat', 10, 8)->nullable();
            $table->decimal('delivery_lng', 11, 8)->nullable();
            $table->timestamp('scheduled_pickup_time')->nullable(); // For pickup
            $table->timestamp('scheduled_delivery_time')->nullable(); // For delivery

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};