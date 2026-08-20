<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('provider_payments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->decimal('regular_price', 12, 2)->default(0);
            $t->decimal('discount_percent', 5, 2)->default(0);
            $t->decimal('discount_amount', 12, 2)->default(0);
            $t->decimal('total_amount', 12, 2)->default(0);
            $t->string('payment_method')->nullable();
            $t->string('sender_number', 40)->nullable();
            $t->string('transaction_id', 120)->nullable()->index();
            $t->string('status')->default('pending');
            $t->text('admin_note')->nullable();
            $t->timestamp('approved_at')->nullable();
            $t->timestamps();
            $t->index(['user_id','status']);
        });

        Schema::create('support_messages', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $t->text('message');
            $t->boolean('is_from_admin')->default(false);
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
            $t->index(['user_id','created_at']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('support_messages');
        Schema::dropIfExists('provider_payments');
    }
};
