<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clients Model
 *
 * @property \App\Model\Table\ProjectsTable&\Cake\ORM\Association\HasMany $Projects
 * @property \App\Model\Table\SalesRecordsTable&\Cake\ORM\Association\HasMany $SalesRecords
 * @method \App\Model\Entity\Client newEmptyEntity()
 * @method \App\Model\Entity\Client newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Client> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Client get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Client findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Client patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Client> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Client|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Client saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Client>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Client>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Client>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Client> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Client>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Client>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Client>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Client> deleteManyOrFail(iterable $entities, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ClientsTable extends Table
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

        $this->setTable('clients');
        $this->setDisplayField('client_code');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Projects', [
            'foreignKey' => 'client_id',
        ]);
        $this->hasMany('SalesRecords', [
            'foreignKey' => 'client_id',
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
            ->scalar('client_code')
            ->maxLength('client_code', 50)
            ->requirePresence('client_code', 'create')
            ->notEmptyString('client_code')
            ->add('client_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
            ->scalar('industry')
            ->maxLength('industry', 100)
            ->allowEmptyString('industry');

        $validator
            ->scalar('contract_type')
            ->allowEmptyString('contract_type');

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
        $rules->add($rules->isUnique(['client_code']), ['errorField' => 'client_code']);

        return $rules;
    }
}
