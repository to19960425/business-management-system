<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TimeRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TimeRecordsTable Test Case
 */
class TimeRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TimeRecordsTable
     */
    protected $TimeRecords;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.TimeRecords',
        'app.Projects',
        'app.Staffs',
        'app.ProjectTasks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TimeRecords') ? [] : ['className' => TimeRecordsTable::class];
        $this->TimeRecords = $this->getTableLocator()->get('TimeRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TimeRecords);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\TimeRecordsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\TimeRecordsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
