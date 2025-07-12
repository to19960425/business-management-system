<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OutsourcingCompaniesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OutsourcingCompaniesTable Test Case
 */
class OutsourcingCompaniesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OutsourcingCompaniesTable
     */
    protected $OutsourcingCompanies;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.OutsourcingCompanies',
        'app.Projects',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OutsourcingCompanies') ? [] : ['className' => OutsourcingCompaniesTable::class];
        $this->OutsourcingCompanies = $this->getTableLocator()->get('OutsourcingCompanies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->OutsourcingCompanies);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\OutsourcingCompaniesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\OutsourcingCompaniesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
