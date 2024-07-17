<?php

namespace Aecor\MasterPassword\Traits;

use App\Models\MasterPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait HasMasterPassword
{
    public function masterPasswords()
    {
        return $this->hasMany(MasterPassword::class);
    }

    public function canHijack()
    {
        return true;
    }

    public function canBeHijacked()
    {
        return true;
    }

    public function generateMasterPassword()
    {
        if (! $this->canBeHijacked()) {
            abort(403);
        }

        if (! auth()->user()->canHijack()) {
            abort(403);
        }

        $token = $this->getPasswordToken();
        $this->masterPasswords()->create([
            'password' => Hash::make($token),
            'created_by' => auth()->id(),
        ]);

        return $token;
    }

    protected function getPasswordToken()
    {
        return (string) Str::uuid();
    }
}
