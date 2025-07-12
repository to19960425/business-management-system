<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Projects Model
 *
 * @property \App\Model\Table\ClientsTable&\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\StaffTable&\Cake\ORM\Association\BelongsTo $Managers
 * @property \App\Model\Table\OutsourcingCompaniesTable&\Cake\ORM\Association\BelongsTo $OutsourcingCompanies
 * @property \App\Model\Table\ProjectTasksTable&\Cake\ORM\Association\HasMany $ProjectTasks
 * @property \App\Model\Table\SalesRecordsTable&\Cake\ORM\Association\HasMany $SalesRecords
 * @property \App\Model\Table\TimeRecordsTable&\Cake\ORM\Association\HasMany $TimeRecords
 * @method \App\Model\Entity\Project newEmptyEntity()
 * @method \App\Model\Entity\Project newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Project> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Project get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Project findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Project patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Project> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Project|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Project saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Project>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Project>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Project>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Project> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Project>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Project>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Project>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Project> deleteManyOrFail(iterable $entities, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProjectsTable extends Table
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

        $this->setTable('projects');
        $this->setDisplayField('project_code');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Managers', [
            'foreignKey' => 'manager_id',
            'className' => 'Staff',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('OutsourcingCompanies', [
            'foreignKey' => 'outsourcing_company_id',
        ]);
        $this->hasMany('ProjectTasks', [
            'foreignKey' => 'project_id',
        ]);
        $this->hasMany('SalesRecords', [
            'foreignKey' => 'project_id',
        ]);
        $this->hasMany('TimeRecords', [
            'foreignKey' => 'project_id',
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
            ->integer('client_id')
            ->notEmptyString('client_id');

        $validator
            ->integer('manager_id')
            ->notEmptyString('manager_id');

        $validator
            ->integer('outsourcing_company_id')
            ->allowEmptyString('outsourcing_company_id');

        $validator
            ->scalar('project_code')
            ->maxLength('project_code', 50)
            ->requirePresence('project_code', 'create')
            ->notEmptyString('project_code')
            ->add('project_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('project_name')
            ->maxLength('project_name', 255)
            ->requirePresence('project_name', 'create')
            ->notEmptyString('project_name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->scalar('priority')
            ->notEmptyString('priority');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->allowEmptyDate('end_date');

        $validator
            ->date('deadline')
            ->allowEmptyDate('deadline');

        $validator
            ->decimal('budget')
            ->allowEmptyString('budget');

        $validator
            ->decimal('estimated_hours')
            ->allowEmptyString('estimated_hours');

        $validator
            ->decimal('hourly_rate')
            ->allowEmptyString('hourly_rate');

        $validator
            ->scalar('contract_type')
            ->notEmptyString('contract_type');

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
        $rules->add($rules->isUnique(['project_code']), ['errorField' => 'project_code']);
        $rules->add($rules->existsIn(['client_id'], 'Clients'), ['errorField' => 'client_id']);
        $rules->add($rules->existsIn(['manager_id'], 'Managers'), ['errorField' => 'manager_id']);
        $rules->add($rules->existsIn(['outsourcing_company_id'], 'OutsourcingCompanies'), ['errorField' => 'outsourcing_company_id']);

        return $rules;
    }
}
