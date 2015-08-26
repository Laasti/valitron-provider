<?php

use League\Container\ServiceProvider;
use Valitron\Validator;

namespace Laasti\ValitronProvider;

class ValitronProvider extends ServiceProvider
{

    protected $provides = [
        'Valitron\Validator'
    ];
    
    protected $defaultConfig = [
        'locale' => null,
        'locales_dir' => null,
        'rules' => []
    ];

    public function register()
    {
        $di = $this->getContainer();
        $config = array_merge($this->defaultConfig, $di['config.validation']);

        if (!is_null($config['locales_dir'])) {
            Validator::langDir($config['locales_dir']);
        }

        $system_lang = !empty($di['config.locale']) ? $di['config.locale'] : 'en';
        $lang = isset($config['locale']) ? $config['locale'] : $system_lang;

        Validator::lang($lang);

        foreach ($config['rules'] as $rule) {
            call_user_func_array('Valitron\Validator::addRule', $rule);
        }

        $di->add('Valitron\Validator', function($data, $fields = [], $lang = null, $langDir = null) {
            return new Validator($data, $fields, $lang, $langDir);
        });
    }

}
