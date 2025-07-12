<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectTask Entity
 *
 * @property int $id
 * @property int $project_id
 * @property int|null $assigned_staff_id
 * @property string $task_name
 * @property string|null $description
 * @property string $status
 * @property string $priority
 * @property string|null $estimated_hours
 * @property string|null $actual_hours
 * @property \Cake\I18n\Date|null $start_date
 * @property \Cake\I18n\Date|null $due_date
 * @property \Cake\I18n\Date|null $completed_date
 * @property string|null $notes
 * @property bool|null $active
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\Staff $assigned_staff
 * @property \App\Model\Entity\TimeRecord[] $time_records
 */
class ProjectTask extends Entity
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
        'project_id' => true,
        'assigned_staff_id' => true,
        'task_name' => true,
        'description' => true,
        'status' => true,
        'priority' => true,
        'estimated_hours' => true,
        'actual_hours' => true,
        'start_date' => true,
        'due_date' => true,
        'completed_date' => true,
        'notes' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'project' => true,
        'assigned_staff' => true,
        'time_records' => true,
    ];
}
