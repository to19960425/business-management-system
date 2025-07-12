<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StaffFixture
 */
class StaffFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'staff';
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
                'user_id' => 1,
                'employee_id' => 'Lorem ipsum dolor sit amet',
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'first_name_kana' => 'Lorem ipsum dolor sit amet',
                'last_name_kana' => 'Lorem ipsum dolor sit amet',
                'phone' => 'Lorem ipsum dolor ',
                'mobile' => 'Lorem ipsum dolor ',
                'position' => 'Lorem ipsum dolor sit amet',
                'department' => 'Lorem ipsum dolor sit amet',
                'hire_date' => '2025-07-12',
                'salary' => 1.5,
                'hourly_rate' => 1.5,
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'active' => 1,
                'created' => '2025-07-12 08:56:24',
                'modified' => '2025-07-12 08:56:24',
            ],
        ];
        parent::init();
    }
}
