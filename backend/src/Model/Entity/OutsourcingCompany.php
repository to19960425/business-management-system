<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OutsourcingCompany Entity
 *
 * @property int $id
 * @property string $company_code
 * @property string $company_name
 * @property string|null $company_name_kana
 * @property string|null $contact_name
 * @property string|null $contact_email
 * @property string|null $contact_phone
 * @property string|null $postal_code
 * @property string|null $address
 * @property string|null $website
 * @property string|null $specialization
 * @property string|null $hourly_rate
 * @property string|null $monthly_rate
 * @property string|null $contract_terms
 * @property string|null $notes
 * @property bool|null $active
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Project[] $projects
 */
class OutsourcingCompany extends Entity
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
        'company_code' => true,
        'company_name' => true,
        'company_name_kana' => true,
        'contact_name' => true,
        'contact_email' => true,
        'contact_phone' => true,
        'postal_code' => true,
        'address' => true,
        'website' => true,
        'specialization' => true,
        'hourly_rate' => true,
        'monthly_rate' => true,
        'contract_terms' => true,
        'notes' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'projects' => true,
    ];
}
