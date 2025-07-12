<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TimeRecords Model
 *
 * @property \App\Model\Table\ProjectsTable&\Cake\ORM\Association\BelongsTo $Projects
 * @property \App\Model\Table\StaffTable&\Cake\ORM\Association\BelongsTo $Staffs
 * @property \App\Model\Table\ProjectTasksTable&\Cake\ORM\Association\BelongsTo $ProjectTasks
 * @method \App\Model\Entity\TimeRecord newEmptyEntity()
 * @method \App\Model\Entity\TimeRecord newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\TimeRecord> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TimeRecord get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\TimeRecord findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\TimeRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\TimeRecord> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TimeRecord|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\TimeRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\TimeRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TimeRecord>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TimeRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TimeRecord> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TimeRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TimeRecord>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TimeRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TimeRecord> deleteManyOrFail(iterable $entities, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TimeRecordsTable extends Table
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

        $this->setTable('time_records');
        $this->setDisplayField('work_type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Staffs', [
            'foreignKey' => 'staff_id',
            'className' => 'Staff',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ProjectTasks', [
            'foreignKey' => 'project_task_id',
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
            ->integer('staff_id')
            ->notEmptyString('staff_id');

        $validator
            ->integer('project_task_id')
            ->allowEmptyString('project_task_id');

        $validator
            ->date('work_date')
            ->requirePresence('work_date', 'create')
            ->notEmptyDate('work_date');

        $validator
            ->time('start_time')
            ->allowEmptyTime('start_time');

        $validator
            ->time('end_time')
            ->allowEmptyTime('end_time');

        $validator
            ->decimal('hours_worked')
            ->requirePresence('hours_worked', 'create')
            ->notEmptyString('hours_worked');

        $validator
            ->decimal('hourly_rate')
            ->allowEmptyString('hourly_rate');

        $validator
            ->decimal('total_amount')
            ->allowEmptyString('total_amount');

        $validator
            ->scalar('work_type')
            ->notEmptyString('work_type');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->boolean('is_billable')
            ->notEmptyString('is_billable');

        $validator
            ->boolean('is_approved')
            ->notEmptyString('is_approved');

        $validator
            ->integer('approved_by')
            ->allowEmptyString('approved_by');

        $validator
            ->dateTime('approved_at')
            ->allowEmptyDateTime('approved_at');

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
        $rules->add($rules->existsIn(['project_id'], 'Projects'), ['errorField' => 'project_id']);
        $rules->add($rules->existsIn(['staff_id'], 'Staffs'), ['errorField' => 'staff_id']);
        $rules->add($rules->existsIn(['project_task_id'], 'ProjectTasks'), ['errorField' => 'project_task_id']);

        return $rules;
    }
}
