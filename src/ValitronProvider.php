<?php

namespace Laasti\ValitronProvider;

use League\Container\ServiceProvider;
use Valitron\Validator;

class ValitronProvider extends ServiceProvider\AbstractServiceProvider
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
        $config = $this->getConfig();

        if (!is_null($config['locales_dir'])) {
            Validator::langDir($config['locales_dir']);
        }
        Validator::lang($config['locale']);
        
        foreach ($config['rules'] as $rule) {
            call_user_func_array('Valitron\Validator::addRule', $rule);
        }

        $di->add('Valitron\Validator', function($data, $fields = [], $lang = null, $langDir = null) {
            return new Validator($data, $fields, $lang, $langDir);
        });
    }

    protected function getConfig()
    {
        $di = $this->getContainer();
        if ($di->has('config') && isset($di->get('config')['valitron'])) {
            $config = $di->get('config')['valitron'];
            if (!isset($config['locale']) && isset($di->get('config')['locale'])) {
                $config['locale'] = $di->get('config')['locale'];
            }
            return $config+$this->defaultConfig;
        }
        return $this->defaultConfig;
    }

}
