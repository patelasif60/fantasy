<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Str;

class AdminUserRepository
{
    public function create($data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => null,
            'username' => $data['email'],
            'status' => $data['status'],
            'provider' => 'email',
        ])->assignRole($data['role']);
    }

    public function update($user, $data)
    {
        $user->fill([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'username' => $data['email'],
            'status' => $data['status'],
        ]);

        $user->save();
        $user->syncRoles($data['role']);

        return $user;
    }

    public function invite(User $user)
    {
        // Delete previous invites
        $user->invite()->delete();

        // Create new invite
        return $user->invite()->create([
            'token' => Str::random(40),
            'invited_at' => now(),
            'invite_accepted_at' => null,
        ]);
    }
}
