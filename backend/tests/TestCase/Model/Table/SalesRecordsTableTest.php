<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SalesRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SalesRecordsTable Test Case
 */
class SalesRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SalesRecordsTable
     */
    protected $SalesRecords;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.SalesRecords',
        'app.Projects',
        'app.Clients',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SalesRecords') ? [] : ['className' => SalesRecordsTable::class];
        $this->SalesRecords = $this->getTableLocator()->get('SalesRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SalesRecords);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\SalesRecordsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\SalesRecordsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
