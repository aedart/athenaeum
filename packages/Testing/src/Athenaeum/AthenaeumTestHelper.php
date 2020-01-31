<?php

namespace Aedart\Testing\Athenaeum;

use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Illuminate\Foundation\Testing\Concerns\InteractsWithContainer;
use Illuminate\Foundation\Testing\Concerns\MocksApplicationServices;

/**
 * Athenaeum Test Helper
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Athenaeum
 */
trait AthenaeumTestHelper
{
    use ApplicationInitiator;
    use InteractsWithConsole;
    use InteractsWithContainer;
    use MocksApplicationServices;
}
