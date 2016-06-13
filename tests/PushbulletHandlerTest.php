<?php

namespace Monobullet;

use Mockery;

class PushbulletHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testPushbulletHandlerIsAliased()
    {
        $pushbullet = Mockery::mock('pushbullet');
        $pushbullet->shouldReceive('user->note')->once();

        $original = new Handler($pushbullet, null);
        $alias = new PushbulletHandler($pushbullet, null);

        $this->assertEquals($original, $alias);
    }
}
