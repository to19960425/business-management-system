<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SalesRecord Entity
 *
 * @property int $id
 * @property int $project_id
 * @property int $client_id
 * @property string $invoice_number
 * @property \Cake\I18n\Date $invoice_date
 * @property \Cake\I18n\Date|null $due_date
 * @property string|null $total_hours
 * @property string|null $hourly_rate
 * @property string $subtotal
 * @property string|null $tax_rate
 * @property string|null $tax_amount
 * @property string $total_amount
 * @property string $payment_status
 * @property \Cake\I18n\Date|null $payment_date
 * @property string|null $payment_method
 * @property string|null $description
 * @property string|null $notes
 * @property bool|null $active
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\Client $client
 */
class SalesRecord extends Entity
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
        'client_id' => true,
        'invoice_number' => true,
        'invoice_date' => true,
        'due_date' => true,
        'total_hours' => true,
        'hourly_rate' => true,
        'subtotal' => true,
        'tax_rate' => true,
        'tax_amount' => true,
        'total_amount' => true,
        'payment_status' => true,
        'payment_date' => true,
        'payment_method' => true,
        'description' => true,
        'notes' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'project' => true,
        'client' => true,
    ];
}
