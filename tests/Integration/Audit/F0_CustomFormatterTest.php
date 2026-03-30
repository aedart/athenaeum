<?php

namespace Integration\Audit;

use Aedart\Audit\Models\AuditTrail;
use Aedart\Contracts\Audit\Formatter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Audit\Category;
use Aedart\Tests\Helpers\Dummies\Audit\Formatters\CategoryAuditTrailFormatter;
use Aedart\Tests\TestCases\Audit\AuditTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * F0_CustomFormatterTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Integration\Audit
 */
#[Group(
    'audit',
    'audit-trail',
    'audit-formatter',
    'audit-custom-formatter',
    'audit-f0',
)]
class F0_CustomFormatterTest extends AuditTestCase
{
    #[Test]
    public function appliesFormatter(): void
    {
        // Create a new model class, with custom formatter

        $categoryClass = new class() extends Category {
            protected $table = 'categories';

            public function auditTrailRecordFormatter(): string|Formatter|null
            {
                return CategoryAuditTrailFormatter::class;
            }
        };

        // ---------------------------------------------------------- //

        $faker = $this->getFaker();

        $reason = 'Be prime.';
        $data = [
            'slug' => $faker->slug(),
            'name' => $faker->name(),
            'description' => $faker->text(),
        ];

        $category = (new $categoryClass())->performChange(function ($model) use ($data) {
            $model
                ->fill($data)
                ->save();

            return $model;
        }, $reason);

        // ---------------------------------------------------------- //

        /** @var AuditTrail $history */
        $history = $category->recordedChanges()->latest('id')->first();

        ConsoleDebugger::output($history->toArray());

        // ---------------------------------------------------------- //

        $this->assertNotNull($history);
        $this->assertSame(strtoupper($reason), $history->message, 'Message not formatted');
        $this->assertArrayHasKey('extra', $history->original_data, 'Original data does not contain additional key');
        $this->assertArrayHasKey('extra', $history->changed_data, 'Changed data does not contain additional key');
    }
}
