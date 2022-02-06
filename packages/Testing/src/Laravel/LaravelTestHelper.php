<?php

namespace Aedart\Testing\Laravel;

use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDeprecationHandling;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\Concerns\InteractsWithRedis;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Foundation\Testing\Concerns\InteractsWithTime;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;

/**
 * Laravel Test Helper
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Laravel
 */
trait LaravelTestHelper
{
    use ApplicationInitiator;
    use InteractsWithAuthentication;
    use InteractsWithConsole;
    use InteractsWithContainer;
    use InteractsWithDatabase;
    use InteractsWithDeprecationHandling;
    use InteractsWithExceptionHandling;
    use InteractsWithRedis;
    use InteractsWithSession;
    use InteractsWithTime;
    use InteractsWithViews;
    use MakesHttpRequests;
}
