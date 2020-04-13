<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class QuestionType extends Enum
{
    const Single =   0;
    const Multiple =   1;
    const Fillable = 2;
}
