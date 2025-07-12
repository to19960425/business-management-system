<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OutsourcingCompanies Model
 *
 * @property \App\Model\Table\ProjectsTable&\Cake\ORM\Association\HasMany $Projects
 * @method \App\Model\Entity\OutsourcingCompany newEmptyEntity()
 * @method \App\Model\Entity\OutsourcingCompany newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\OutsourcingCompany> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OutsourcingCompany get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\OutsourcingCompany findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\OutsourcingCompany patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\OutsourcingCompany> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OutsourcingCompany|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\OutsourcingCompany saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\OutsourcingCompany>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OutsourcingCompany>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OutsourcingCompany>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OutsourcingCompany> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OutsourcingCompany>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OutsourcingCompany>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OutsourcingCompany>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OutsourcingCompany> deleteManyOrFail(iterable $entities, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OutsourcingCompaniesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('outsourcing_companies');
        $this->setDisplayField('company_code');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Projects', [
            'foreignKey' => 'outsourcing_company_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('company_code')
            ->maxLength('company_code', 50)
            ->requirePresence('company_code', 'create')
            ->notEmptyString('company_code')
            ->add('company_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('company_name')
            ->maxLength('company_name', 255)
            ->requirePresence('company_name', 'create')
            ->notEmptyString('company_name');

        $validator
            ->scalar('company_name_kana')
            ->maxLength('company_name_kana', 255)
            ->allowEmptyString('company_name_kana');

        $validator
            ->scalar('contact_name')
            ->maxLength('contact_name', 100)
            ->allowEmptyString('contact_name');

        $validator
            ->scalar('contact_email')
            ->maxLength('contact_email', 255)
            ->allowEmptyString('contact_email');

        $validator
            ->scalar('contact_phone')
            ->maxLength('contact_phone', 20)
            ->allowEmptyString('contact_phone');

        $validator
            ->scalar('postal_code')
            ->maxLength('postal_code', 10)
            ->allowEmptyString('postal_code');

        $validator
            ->scalar('address')
            ->allowEmptyString('address');

        $validator
            ->scalar('website')
            ->maxLength('website', 255)
            ->allowEmptyString('website');

        $validator
            ->scalar('specialization')
            ->maxLength('specialization', 100)
            ->allowEmptyString('specialization');

        $validator
            ->decimal('hourly_rate')
            ->allowEmptyString('hourly_rate');

        $validator
            ->decimal('monthly_rate')
            ->allowEmptyString('monthly_rate');

        $validator
            ->scalar('contract_terms')
            ->allowEmptyString('contract_terms');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['company_code']), ['errorField' => 'company_code']);

        return $rules;
    }
}
