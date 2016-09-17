<?php

namespace SilverStripe\Tests\GraphQL;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\GraphQL\Manager;
use SilverStripe\GraphQL\Controller;
use SilverStripe\GraphQL\Tests\Fake\TypeCreatorFake;
use SilverStripe\Core\Config\Config;
use ReflectionClass;

class ControllerTest extends SapphireTest
{

    public function testGetGetManagerPopulatesFromConfig()
    {
        Config::inst()->update('SilverStripe\GraphQL', 'schema', [
            'types' => [
                'mytype' => 'SilverStripe\GraphQL\Tests\Fake\TypeCreatorFake',
            ]
        ]);

        $controller = new Controller();
        $reflection = new ReflectionClass($controller);
        $method = $reflection->getMethod('getManager');
        $method->setAccessible(true);
        $manager = $method->invoke($controller);
        $this->assertInstanceOf(
            'SilverStripe\GraphQL\Tests\Fake\TypeCreatorFake',
            $manager->getType('mytype')
        );
    }

}