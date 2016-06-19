<?php

namespace Monobullet;

use Monolog\Formatter\NormalizerFormatter;

class Formatter extends NormalizerFormatter
{
    protected function cleanClassName($string)
    {
        return preg_replace('~[a-z_\x7f-\xff\\\\][a-z0-9_\x7f-\xff\\\\]*\\\\~i', null, $string);
    }

    protected function cleanFileName($string)
    {
        return preg_replace('~/['.DIRECTORY_SEPARATOR.'a-z0-9_-]+'.DIRECTORY_SEPARATOR.'~i', null, $string);
    }

    protected function clean($string)
    {
        return $this->cleanFileName($this->cleanClassName($string));
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        $record['title'] = '[%s] '.$record['level_name'];

        if (function_exists('config') && method_exists(config(), 'get')) {
            $record['title'] = sprintf($record['title'], config()->get('services.monobullet.name'));
        } else {
            $record['title'] = sprintf($record['title'], $record['channel']);
        }

        if (strncasecmp($record['message'], 'exception ', 10) !== 0) {
            return $record;
        }

        if (($nl = strpos($record['message'], PHP_EOL)) !== false) {
            $message = substr($record['message'], 0, $nl);
            $stack = array_slice(explode(PHP_EOL, $record['message']), 2);
            $ministack = array_slice($stack, 0, 5);

            $message = $this->clean($message);
            foreach ($stack as &$s) {
                $s = $this->clean($s);
            }

            $record['message'] = sprintf(
                '%s'.PHP_EOL.'----------'.PHP_EOL.'%s',
                $message,
                implode(PHP_EOL.PHP_EOL, $ministack)
            );
            $record['extra']['stack'] = $stack;
        }

        return $record;
    }
    /**
     * {@inheritdoc}
     */
    public function formatBatch(array $records)
    {
        foreach ($records as $key => $record) {
            $records[$key] = $this->format($record);
        }
        return $records;
    }
}
