<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectTasks Model
 *
 * @property \App\Model\Table\ProjectsTable&\Cake\ORM\Association\BelongsTo $Projects
 * @property \App\Model\Table\StaffTable&\Cake\ORM\Association\BelongsTo $AssignedStaffs
 * @property \App\Model\Table\TimeRecordsTable&\Cake\ORM\Association\HasMany $TimeRecords
 * @method \App\Model\Entity\ProjectTask newEmptyEntity()
 * @method \App\Model\Entity\ProjectTask newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ProjectTask> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProjectTask get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ProjectTask findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ProjectTask patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ProjectTask> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectTask|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ProjectTask saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ProjectTask>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProjectTask>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProjectTask>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProjectTask> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProjectTask>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProjectTask>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProjectTask>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProjectTask> deleteManyOrFail(iterable $entities, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProjectTasksTable extends Table
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

        $this->setTable('project_tasks');
        $this->setDisplayField('task_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('AssignedStaffs', [
            'foreignKey' => 'assigned_staff_id',
            'className' => 'Staff',
        ]);
        $this->hasMany('TimeRecords', [
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
            ->integer('assigned_staff_id')
            ->allowEmptyString('assigned_staff_id');

        $validator
            ->scalar('task_name')
            ->maxLength('task_name', 255)
            ->requirePresence('task_name', 'create')
            ->notEmptyString('task_name');

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
            ->decimal('estimated_hours')
            ->allowEmptyString('estimated_hours');

        $validator
            ->decimal('actual_hours')
            ->allowEmptyString('actual_hours');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('due_date')
            ->allowEmptyDate('due_date');

        $validator
            ->date('completed_date')
            ->allowEmptyDate('completed_date');

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
        $rules->add($rules->existsIn(['assigned_staff_id'], 'AssignedStaffs'), ['errorField' => 'assigned_staff_id']);

        return $rules;
    }
}
