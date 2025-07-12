<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Project Entity
 *
 * @property int $id
 * @property int $client_id
 * @property int $manager_id
 * @property int|null $outsourcing_company_id
 * @property string $project_code
 * @property string $project_name
 * @property string|null $description
 * @property string $status
 * @property string $priority
 * @property \Cake\I18n\Date|null $start_date
 * @property \Cake\I18n\Date|null $end_date
 * @property \Cake\I18n\Date|null $deadline
 * @property string|null $budget
 * @property string|null $estimated_hours
 * @property string|null $hourly_rate
 * @property string $contract_type
 * @property string|null $notes
 * @property bool|null $active
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Staff $manager
 * @property \App\Model\Entity\OutsourcingCompany $outsourcing_company
 * @property \App\Model\Entity\ProjectTask[] $project_tasks
 * @property \App\Model\Entity\SalesRecord[] $sales_records
 * @property \App\Model\Entity\TimeRecord[] $time_records
 */
class Project extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'client_id' => true,
        'manager_id' => true,
        'outsourcing_company_id' => true,
        'project_code' => true,
        'project_name' => true,
        'description' => true,
        'status' => true,
        'priority' => true,
        'start_date' => true,
        'end_date' => true,
        'deadline' => true,
        'budget' => true,
        'estimated_hours' => true,
        'hourly_rate' => true,
        'contract_type' => true,
        'notes' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'client' => true,
        'manager' => true,
        'outsourcing_company' => true,
        'project_tasks' => true,
        'sales_records' => true,
        'time_records' => true,
    ];
}
