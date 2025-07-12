<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Staff Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $employee_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $first_name_kana
 * @property string|null $last_name_kana
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $position
 * @property string|null $department
 * @property \Cake\I18n\Date|null $hire_date
 * @property string|null $salary
 * @property string|null $hourly_rate
 * @property string|null $notes
 * @property bool|null $active
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\TimeRecord[] $time_records
 */
class Staff extends Entity
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
        'user_id' => true,
        'employee_id' => true,
        'first_name' => true,
        'last_name' => true,
        'first_name_kana' => true,
        'last_name_kana' => true,
        'phone' => true,
        'mobile' => true,
        'position' => true,
        'department' => true,
        'hire_date' => true,
        'salary' => true,
        'hourly_rate' => true,
        'notes' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'time_records' => true,
    ];
}
