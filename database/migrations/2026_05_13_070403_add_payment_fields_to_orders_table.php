<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->default('cod')->after('notes');
            $table->string('payment_status')->default('pending')->after('payment_method');
            $table->string('payment_proof')->nullable()->after('payment_status');
            $table->decimal('shipping_fee', 10, 2)->default(200)->after('payment_proof');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'payment_proof', 'shipping_fee']);
        });
    }
};
