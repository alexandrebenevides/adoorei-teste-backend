<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    static $setUpExecuted = false;

    public function setUp(): void
    {
        parent::setUp();

        if (!static::$setUpExecuted) {
            Artisan::call('migrate:fresh', ['--env' => 'testing']);
            Artisan::call('db:seed', ['--env' => 'testing']);
            static::$setUpExecuted = true;
        }
    }
}
