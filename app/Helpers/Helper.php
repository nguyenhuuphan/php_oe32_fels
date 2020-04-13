<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Enums\WordType;
use App\Enums\UserRole;
use App\Enums\QuestionType;

class Helper
{
    public static function getWordTypes()
    {
        return WordType::getKeys();
    }

    public static function getWordType($type)
    {
        return WordType::getKey($type);
    }

    public static function getQuestionTypes()
    {
        return QuestionType::getKeys();
    }

    public static function getQuestionType($type)
    {
        return QuestionType::getKey($type);
    }

    public static function isAdmin($user)
    {
        if ($user->role === UserRole::Administrator) {
            return true;
        }
        return false;
    }
}