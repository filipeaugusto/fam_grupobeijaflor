<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExpenseCategories Model
 *
 * @property \App\Model\Table\ExpenseCategoriesTable&\Cake\ORM\Association\BelongsTo $ParentExpenseCategories
 * @property \App\Model\Table\BillingsTable&\Cake\ORM\Association\HasMany $Billings
 * @property \App\Model\Table\ExpenseCategoriesTable&\Cake\ORM\Association\HasMany $ChildExpenseCategories
 * @property \App\Model\Table\PaymentsTable&\Cake\ORM\Association\HasMany $Payments
 *
 * @method \App\Model\Entity\ExpenseCategory newEmptyEntity()
 * @method \App\Model\Entity\ExpenseCategory newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ExpenseCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExpenseCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExpenseCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ExpenseCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExpenseCategory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExpenseCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExpenseCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExpenseCategory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExpenseCategory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExpenseCategory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExpenseCategory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class ExpenseCategoriesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('expense_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Search.Search');

        $this->searchManager()
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['name'],
            ]);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree', [
            'level' => 'level'
        ]);

        $this->belongsTo('ParentExpenseCategories', [
            'className' => 'ExpenseCategories',
            'foreignKey' => 'parent_id',
            'conditions' => ['ParentExpenseCategories.parent_id IS NULL'],
            'order' => ['ParentExpenseCategories.lft' => 'ASC']
        ]);
        $this->hasMany('Billings', [
            'foreignKey' => 'expense_category_id',
        ]);
        $this->hasMany('ChildExpenseCategories', [
            'className' => 'ExpenseCategories',
            'foreignKey' => 'parent_id',
            'order' => ['ChildExpenseCategories.lft' => 'ASC']
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'expense_category_id',
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
            ->uuid('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('level')
            ->allowEmptyString('level');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentExpenseCategories'), ['errorField' => 'parent_id']);

        return $rules;
    }
}
