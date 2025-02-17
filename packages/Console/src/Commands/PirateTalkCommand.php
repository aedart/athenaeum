<?php

namespace Aedart\Console\Commands;

use Aedart\Utils\Arr;
use Illuminate\Console\Command;
use Throwable;

/**
 * Pirate Talk Command
*
 * Intended for testing purposes... or for fun!
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console\Commands
 */
class PirateTalkCommand extends Command
{
    /**
     * Name of command
     *
     * @var string
     */
    protected $signature = 'pirate:talk';

    /**
     * Description of command
     *
     * @var string
     */
    protected $description = 'Make the pirate talk!';

    /**
     * Execute this command
     *
     * @return int
     *
     * @throws Throwable
     */
    public function handle(): int
    {
        // Text generated via Kay Stenschke's Dummy Text Generator
        // @see https://plugins.jetbrains.com/plugin/7216-dummy-text-generator
        $sentences = [
            'Landlubber of a black fight, lead the adventure!',
            'Anchors are the bilge rats of the salty life.',
            'Beauty ho! lead to be robed.',
            'Bilge rats are the cannibals of the lively life.',
            'All winds haul lively, dark fishs.',
            'Ho-ho-ho! strength of amnesty.',
            'Well there\'s nothing like the evil desolation hobbling on the scallywag.',
            'Yardarms rise with faith at the dark singapore!',
            'Where is the big cannibal?',
            'Yuck, life!',
            'Fortune, death, and halitosis.',
            'Grogs travel on beauty at pantano river!',
            'Mainland of a swashbuckling life, burn the horror!',
            'Ah! Pieces o\' passion are forever dark.',
            'Belay, yer not hoisting me without a greed!',
            'Jacks are the pants of the golden madness.',
            'Stormy, scurvy jacks cowardly mark a lively, salty moon.',
            'Life, power, and treasure.',
            'Fine, golden skulls calmly raid a clear, wet shore.',
            'Lord, swashbuckling death!',
            'The seashell commands with halitosis, blow the reef before it dies.'
        ];

        // Say something, you pirate!
        $this->output->text(Arr::randomizer()->value($sentences));

        return 0;
    }
}
