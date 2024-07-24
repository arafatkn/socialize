<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $users = User::all();
        $users->each(function (User $user) use ($users) {
            $user->username = strtolower(Str::before($user->email, '@'));
            $user->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $users = User::all();
        $users->each(function (User $user) use ($users) {
            $user->username = $user->id;
            $user->save();
        });
    }
};
