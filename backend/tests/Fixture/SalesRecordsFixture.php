<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SalesRecordsFixture
 */
class SalesRecordsFixture extends TestFixture
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
                'project_id' => 1,
                'client_id' => 1,
                'invoice_number' => 'Lorem ipsum dolor sit amet',
                'invoice_date' => '2025-07-12',
                'due_date' => '2025-07-12',
                'total_hours' => 1.5,
                'hourly_rate' => 1.5,
                'subtotal' => 1.5,
                'tax_rate' => 1.5,
                'tax_amount' => 1.5,
                'total_amount' => 1.5,
                'payment_status' => 'Lorem ipsum dolor sit amet',
                'payment_date' => '2025-07-12',
                'payment_method' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'active' => 1,
                'created' => '2025-07-12 08:56:42',
                'modified' => '2025-07-12 08:56:42',
            ],
        ];
        parent::init();
    }
}
