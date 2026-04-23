<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('password');
            $table->string('currency')->default('IDR')->after('avatar');
            $table->string('locale')->default('id')->after('currency');
            $table->boolean('notify_weekly_report')->default(true)->after('locale');
            $table->boolean('notify_budget_alert')->default(true)->after('notify_weekly_report');
            $table->boolean('notify_marketing_tips')->default(false)->after('notify_budget_alert');
            $table->timestamp('notif_read_at')->nullable()->after('notify_marketing_tips');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'currency',
                'locale',
                'notify_weekly_report',
                'notify_budget_alert',
                'notify_marketing_tips',
                'notif_read_at',
            ]);
        });
    }
};
