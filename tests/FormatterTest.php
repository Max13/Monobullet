<?php

namespace Monobullet;

use Mockery;
use Monolog\Logger;

class FormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testRecordStructureForUsualMessage()
    {
        $pushbullet = Mockery::mock('pushbullet');
        $pushbullet->shouldReceive('user->note')->once();

        $logger = new Logger('MonobulletTest');
        $logger->pushHandler(new Handler($pushbullet, null));
        $logger->info('This is just a test log');

        $record = $logger->getHandlers()[0]->getLastRecord();

        $this->assertArrayHasKey('formatted', $record);
        $this->assertArrayHasKey('title', $record['formatted']);
        $this->assertEmpty($record['extra']);
    }

    public function testRecordStructureForException()
    {
        $pushbullet = Mockery::mock('pushbullet');
        $pushbullet->shouldReceive('user->note')->once();

        $logger = new Logger('MonobulletTest');
        $logger->pushHandler(new Handler($pushbullet, null));
        $logger->info('exception \'ErrorException\' with message \'Undefined property: stdClass::$dummy\' in /tmp/non-existant.php:27'.PHP_EOL.'Stack trace:'.PHP_EOL.'#0 /tmp/04227d.php(27): HandleExceptions->handleError(8, \'Undefined prope...\', \'/tmp/non-exi...\', 27, Array)'.PHP_EOL.'#1 /tmp/AnotherDummy.php(42): include(\'/tmp/non-exis...\')'.PHP_EOL.'#2 /tmp/WowStillDummy.php(59): Method->DumDum(\'/tmp/che...\', Array)');

        $record = $logger->getHandlers()[0]->getLastRecord();

        $this->assertArrayHasKey('formatted', $record);
        $this->assertArrayHasKey('title', $record['formatted']);
        $this->assertArrayHasKey('stack', $record['formatted']['extra']);
    }
}
