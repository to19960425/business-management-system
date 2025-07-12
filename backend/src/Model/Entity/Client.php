<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Client Entity
 *
 * @property int $id
 * @property string $client_code
 * @property string $company_name
 * @property string|null $company_name_kana
 * @property string|null $contact_name
 * @property string|null $contact_email
 * @property string|null $contact_phone
 * @property string|null $postal_code
 * @property string|null $address
 * @property string|null $website
 * @property string|null $industry
 * @property string|null $contract_type
 * @property string|null $notes
 * @property bool|null $active
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Project[] $projects
 * @property \App\Model\Entity\SalesRecord[] $sales_records
 */
class Client extends Entity
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
        'client_code' => true,
        'company_name' => true,
        'company_name_kana' => true,
        'contact_name' => true,
        'contact_email' => true,
        'contact_phone' => true,
        'postal_code' => true,
        'address' => true,
        'website' => true,
        'industry' => true,
        'contract_type' => true,
        'notes' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'projects' => true,
        'sales_records' => true,
    ];
}
