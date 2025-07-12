<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SalesRecords Model
 *
 * @property \App\Model\Table\ProjectsTable&\Cake\ORM\Association\BelongsTo $Projects
 * @property \App\Model\Table\ClientsTable&\Cake\ORM\Association\BelongsTo $Clients
 * @method \App\Model\Entity\SalesRecord newEmptyEntity()
 * @method \App\Model\Entity\SalesRecord newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\SalesRecord> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SalesRecord get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\SalesRecord findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\SalesRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\SalesRecord> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SalesRecord|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\SalesRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\SalesRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SalesRecord>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SalesRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SalesRecord> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SalesRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SalesRecord>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SalesRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SalesRecord> deleteManyOrFail(iterable $entities, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SalesRecordsTable extends Table
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

        $this->setTable('sales_records');
        $this->setDisplayField('invoice_number');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER',
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
            ->integer('project_id')
            ->notEmptyString('project_id');

        $validator
            ->integer('client_id')
            ->notEmptyString('client_id');

        $validator
            ->scalar('invoice_number')
            ->maxLength('invoice_number', 50)
            ->requirePresence('invoice_number', 'create')
            ->notEmptyString('invoice_number')
            ->add('invoice_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->date('invoice_date')
            ->requirePresence('invoice_date', 'create')
            ->notEmptyDate('invoice_date');

        $validator
            ->date('due_date')
            ->allowEmptyDate('due_date');

        $validator
            ->decimal('total_hours')
            ->allowEmptyString('total_hours');

        $validator
            ->decimal('hourly_rate')
            ->allowEmptyString('hourly_rate');

        $validator
            ->decimal('subtotal')
            ->requirePresence('subtotal', 'create')
            ->notEmptyString('subtotal');

        $validator
            ->decimal('tax_rate')
            ->allowEmptyString('tax_rate');

        $validator
            ->decimal('tax_amount')
            ->allowEmptyString('tax_amount');

        $validator
            ->decimal('total_amount')
            ->requirePresence('total_amount', 'create')
            ->notEmptyString('total_amount');

        $validator
            ->scalar('payment_status')
            ->notEmptyString('payment_status');

        $validator
            ->date('payment_date')
            ->allowEmptyDate('payment_date');

        $validator
            ->scalar('payment_method')
            ->allowEmptyString('payment_method');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

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
        $rules->add($rules->isUnique(['invoice_number']), ['errorField' => 'invoice_number']);
        $rules->add($rules->existsIn(['project_id'], 'Projects'), ['errorField' => 'project_id']);
        $rules->add($rules->existsIn(['client_id'], 'Clients'), ['errorField' => 'client_id']);

        return $rules;
    }
}
