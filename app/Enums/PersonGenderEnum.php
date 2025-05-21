<?php

namespace App\Enums;

enum PersonGenderEnum: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case NOT_BINARY = 'not_binary';
    case OTHER = 'other';
    case PREFER_NOT_TO_SAY = 'preferred_not_to_say';
}