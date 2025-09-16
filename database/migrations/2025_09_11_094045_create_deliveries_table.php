<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_deliveries_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade'); // user with role 'driver'
            $table->enum('status', ['assigned', 'picked_up', 'in_transit', 'delivered', 'failed'])->default('assigned');
            $table->text('notes')->nullable(); // Driver notes (e.g., "left at front door")
            $table->timestamp('estimated_delivery_time')->nullable();
            $table->timestamp('actual_delivery_time')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
};