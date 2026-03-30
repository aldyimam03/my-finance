<?php

namespace App\Policies;

use App\Models\Wallet;
use App\Models\User;

class WalletPolicy
{
    public function update(User $user, Wallet $wallet): bool
    {
        return $user->id == $wallet->user_id;
    }

    public function delete(User $user, Wallet $wallet): bool
    {
        return $user->id == $wallet->user_id;
    }
}
