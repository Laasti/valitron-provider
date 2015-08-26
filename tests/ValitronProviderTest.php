<?php

namespace Laasti\ValitronProvider\Tests;

use Laasti\ValitronProvider\ValitronProvider;
use League\Container\Container;

class ValitronProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testConfiguration()
    {
        $called = false;
        $container = new Container(['di' => [
                'config.validation' => [
                    'locale' => 'fr',
                    'locales_dir' => __DIR__.'/langs',
                    'rules' => [
                        ['custom', function() use (&$called) {
                            $called = true;
                            return true;
                        }, 'Everything you do is wrong. You fail.']
                    ]
                ]
            ]
        ]);
        $container->addServiceProvider(new ValitronProvider);
        $validator = $container->get('Valitron\Validator', [['test' => 'data']]);
        $validator->rule('custom', 'test');
        $validator->validate();
        $this->assertTrue($validator->lang() === 'fr');
        $this->assertTrue($validator->langDir() === __DIR__.'/langs');
        $this->assertTrue($called);
    }

}
