<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function store($data)
    {
        $user = User::create([
            "email" => $data["email"],
            "password" => $data["password"]
        ]);

        return $user;
    }
}
