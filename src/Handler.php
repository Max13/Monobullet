<?php

namespace Monobullet;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use PHPushbullet\PHPushbullet;

class Handler extends AbstractProcessingHandler
{
    protected $lastRecord = null;
    private $pushbullet;
    protected $recipients = [];

    public function __construct($token, $recipients, $level = Logger::INFO, $bubble = false)
    {
        $this->pushbullet = is_string($token) ? new PHPushbullet($token) : $token;
        $this->recipients = is_array($recipients) ? $recipients : [$recipients];

        parent::__construct($level, $bubble);
    }

    protected function write(array $record)
    {
        $this->lastRecord = $record;

        $this->pushbullet->user($this->recipients)
                         ->note($record['formatted']['title'], $record['formatted']['message']);
    }

    protected function getDefaultFormatter()
    {
        return new Formatter();
    }

    public function getLastRecord()
    {
        return $this->lastRecord;
    }
}
