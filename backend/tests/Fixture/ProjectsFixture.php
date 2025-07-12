<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProjectsFixture
 */
class ProjectsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'client_id' => 1,
                'manager_id' => 1,
                'outsourcing_company_id' => 1,
                'project_code' => 'Lorem ipsum dolor sit amet',
                'project_name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => 'Lorem ipsum dolor sit amet',
                'priority' => 'Lorem ipsum dolor sit amet',
                'start_date' => '2025-07-12',
                'end_date' => '2025-07-12',
                'deadline' => '2025-07-12',
                'budget' => 1.5,
                'estimated_hours' => 1.5,
                'hourly_rate' => 1.5,
                'contract_type' => 'Lorem ipsum dolor sit amet',
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'active' => 1,
                'created' => '2025-07-12 08:56:32',
                'modified' => '2025-07-12 08:56:32',
            ],
        ];
        parent::init();
    }
}
