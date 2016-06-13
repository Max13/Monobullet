<?php

namespace Monobullet;

if (!class_alias('Monobullet\Handler', 'Monobullet\PushbulletHandler')) {
    throw new Exception('Monobullet\Handler could not be aliased as Monobuller\Pushbullet.'.PHP_EOL
                        .'Please report the issue and use Monobullet\Handler while waiting for a fix');

}
