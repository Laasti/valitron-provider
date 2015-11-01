<?php

namespace Laasti\ValitronProvider;

use Valitron\Validator;

trait ValitronFactoryTrait
{

    public function createValidator($data, $fields = [], $lang = null, $langDir = null)
    {
        return new Validator($data, $fields, $lang, $langDir);
    }

}
