<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TimeRecord Entity
 *
 * @property int $id
 * @property int $project_id
 * @property int $staff_id
 * @property int|null $project_task_id
 * @property \Cake\I18n\Date $work_date
 * @property \Cake\I18n\Time|null $start_time
 * @property \Cake\I18n\Time|null $end_time
 * @property string $hours_worked
 * @property string|null $hourly_rate
 * @property string|null $total_amount
 * @property string $work_type
 * @property string|null $description
 * @property bool $is_billable
 * @property bool $is_approved
 * @property int|null $approved_by
 * @property \Cake\I18n\DateTime|null $approved_at
 * @property string|null $notes
 * @property bool|null $active
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\Staff $staff
 * @property \App\Model\Entity\ProjectTask $project_task
 */
class TimeRecord extends Entity
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
        'staff_id' => true,
        'project_task_id' => true,
        'work_date' => true,
        'start_time' => true,
        'end_time' => true,
        'hours_worked' => true,
        'hourly_rate' => true,
        'total_amount' => true,
        'work_type' => true,
        'description' => true,
        'is_billable' => true,
        'is_approved' => true,
        'approved_by' => true,
        'approved_at' => true,
        'notes' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'project' => true,
        'staff' => true,
        'project_task' => true,
    ];
}
