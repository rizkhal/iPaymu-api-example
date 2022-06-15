<?php

use App\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('job');
            $table->date('birth_date');
            $table->uuid('uuid_key');
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image');
            $table->foreignUuid('category_id');
            $table->string('name');
            $table->tinyInteger('qty');
            $table->unsignedBigInteger('price');
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id');
            $table->foreignUuid('user_id');
            $table->tinyInteger('qty');
            $table->tinyInteger('status')->comment(PaymentStatus::class);
            $table->string('ipaymu_session_id');
            $table->string('ipaymu_session_url');
            $table->timestamps();
        });

        Schema::create('payment_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('payment_id')->constrained('payments', 'id')->onDelete('cascade');
            $table->string('trx_id');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('payment_details');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('products');
    }
};
