<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('complaints',function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();$t->string('subject');$t->text('description');$t->string('status')->default('new');$t->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();$t->text('admin_note')->nullable();$t->timestamps();});
  Schema::create('referrals',function(Blueprint $t){$t->id();$t->foreignId('referrer_id')->constrained('users')->cascadeOnDelete();$t->foreignId('referred_user_id')->nullable()->constrained('users')->nullOnDelete();$t->string('code')->index();$t->integer('points')->default(0);$t->decimal('commission',12,2)->default(0);$t->string('status')->default('pending');$t->timestamps();});
  Schema::create('settings',function(Blueprint $t){$t->id();$t->string('key')->unique();$t->text('value')->nullable();$t->string('group')->default('general');$t->timestamps();});
  Schema::create('notifications',function(Blueprint $t){$t->uuid('id')->primary();$t->string('type');$t->string('notifiable_type');$t->unsignedBigInteger('notifiable_id');$t->text('data');$t->timestamp('read_at')->nullable();$t->timestamps();$t->index(['notifiable_type','notifiable_id']);});
  Schema::create('sessions',function(Blueprint $t){$t->string('id')->primary();$t->foreignId('user_id')->nullable()->index();$t->string('ip_address',45)->nullable();$t->text('user_agent')->nullable();$t->text('payload');$t->integer('last_activity')->index();});
 }
 public function down(): void {Schema::dropIfExists('sessions');Schema::dropIfExists('notifications');Schema::dropIfExists('settings');Schema::dropIfExists('referrals');Schema::dropIfExists('complaints');}
};
