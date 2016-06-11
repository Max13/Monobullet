<?php

namespace Monobullet;

use Mockery;
use Monolog\Logger;

class HandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testPushbulletIsCorrectlyCalled()
    {
        $pushbullet = Mockery::mock('pushbullet');
        $pushbullet->shouldReceive('user->note')->once();

        $logger = new Logger('MonobulletTest');
        $logger->pushHandler(new Handler($pushbullet, null));
        $logger->info('This is just a test log');
    }
}
