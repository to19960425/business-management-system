<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Staff Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\TimeRecordsTable&\Cake\ORM\Association\HasMany $TimeRecords
 * @method \App\Model\Entity\Staff newEmptyEntity()
 * @method \App\Model\Entity\Staff newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Staff> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Staff get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Staff findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Staff patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Staff> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Staff|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Staff saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Staff>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Staff>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Staff>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Staff> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Staff>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Staff>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Staff>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Staff> deleteManyOrFail(iterable $entities, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StaffTable extends Table
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

        $this->setTable('staff');
        $this->setDisplayField('employee_id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('TimeRecords', [
            'foreignKey' => 'staff_id',
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
            ->integer('user_id')
            ->notEmptyString('user_id')
            ->add('user_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('employee_id')
            ->maxLength('employee_id', 50)
            ->requirePresence('employee_id', 'create')
            ->notEmptyString('employee_id')
            ->add('employee_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 100)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 100)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->scalar('first_name_kana')
            ->maxLength('first_name_kana', 100)
            ->allowEmptyString('first_name_kana');

        $validator
            ->scalar('last_name_kana')
            ->maxLength('last_name_kana', 100)
            ->allowEmptyString('last_name_kana');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 20)
            ->allowEmptyString('phone');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 20)
            ->allowEmptyString('mobile');

        $validator
            ->scalar('position')
            ->maxLength('position', 100)
            ->allowEmptyString('position');

        $validator
            ->scalar('department')
            ->maxLength('department', 100)
            ->allowEmptyString('department');

        $validator
            ->date('hire_date')
            ->allowEmptyDate('hire_date');

        $validator
            ->decimal('salary')
            ->allowEmptyString('salary');

        $validator
            ->decimal('hourly_rate')
            ->allowEmptyString('hourly_rate');

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
        $rules->add($rules->isUnique(['employee_id']), ['errorField' => 'employee_id']);
        $rules->add($rules->isUnique(['user_id']), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
