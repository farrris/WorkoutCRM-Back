<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case Admin = 'admin';
    case Trainer = 'trainer';
    case Athlete = 'athlete';
}
