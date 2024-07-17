<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class ConsumerUserRepository
{
    public function create($data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(),
            'username' => Arr::get($data, 'username', $data['email']),
            'status' => $data['status'],
            'provider' => 'email',
        ])->assignDefaultRole();
    }

    public function update($user, $data)
    {
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->username = Arr::get($data, 'username', $data['email']);
        $user->status = $data['status'];

        return $user->save();
    }
}
