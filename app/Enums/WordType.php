<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class WordType extends Enum
{
    const Nouns = 0;
    const Verb = 1;
    const Adjective = 2;
    const Adverb = 3;
}
