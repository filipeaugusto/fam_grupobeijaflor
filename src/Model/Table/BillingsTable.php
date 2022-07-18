<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Billing;
use App\Model\Entity\User;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Billings Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\ExpenseCategoriesTable&\Cake\ORM\Association\BelongsTo $ExpenseCategories
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $RemovedUsers
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $ConfirmationUsers
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\BelongsTo $Accounts
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $ConfirmationUser
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $RemovedUser
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\AttachmentsTable&\Cake\ORM\Association\HasMany $Attachments
 *
 * @method \App\Model\Entity\Billing newEmptyEntity()
 * @method \App\Model\Entity\Billing newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Billing[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Billing get($primaryKey, $options = [])
 * @method \App\Model\Entity\Billing findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Billing patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Billing[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Billing|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Billing saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Billing[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Billing[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Billing[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Billing[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillingsTable extends Table
{
    const INPUT = 'input';
    const OUTPUT = 'output';
    const CONTROL = 'control';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('billings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Search.Search');
        $this->addBehavior('Tree', [
            'level' => 'level'
        ]);

        $this->searchManager()
            ->value('company_id')
            ->value('model')
            ->value('foreing_key')
            ->value('account_id')
            ->value('partner_id')
            ->value('user_id')
            ->value('expense_category_id')
            ->value('value')
            ->value('type')
            ->value('confirmation')
            ->value('removed')
            ->value('authorization')
            ->add('description', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['description']
            ])
            ->add('limit_deadline', 'Search.Callback', [
                'callback' => function (Query $query, $args, $filter) {
                    $query
                        ->andWhere(['Billings.deadline >=' => FrozenTime::now()->subDays((int) $args['limit_deadline'] ?? 30)]);
                }
            ])
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['id', 'description'],
            ]);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ConfirmationUsers', [
            'className' => 'Users',
            'foreignKey' => 'confirmation_user_id',
        ]);
        $this->belongsTo('RemovedUsers', [
            'className' => 'Users',
            'foreignKey' => 'removed_user_id',
        ]);
        $this->belongsTo('CreatedUsers', [
            'className' => 'Users',
            'foreignKey' => 'created_user_id',
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
        ]);
        $this->belongsTo('ExpenseCategories', [
            'foreignKey' => 'expense_category_id',
        ]);
        $this->belongsTo('CheckControls', [
            'className' => 'CheckControls',
            'foreignKey' => 'foreing_key',
            'conditions' => ['Billings.model' => 'CheckControls']
        ]);
        $this->belongsTo('Partners', [
            'foreignKey' => 'partner_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'billing_id',
        ]);
        $this->hasMany('Attachments', [
            'foreignKey' => 'foreing_key',
            'conditions' => ['Attachments.model' => 'Billings']
        ]);

        $this->belongsTo('ParentBillings', [
            'className' => 'Billings',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ChildBillings', [
            'className' => 'Billings',
            'foreignKey' => 'parent_id',
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
            ->scalar('model')
            ->maxLength('model', 150)
            ->allowEmptyString('model');

        $validator
            ->uuid('foreing_key')
            ->allowEmptyString('foreing_key');

        $validator
            ->date('deadline')
            ->allowEmptyDate('deadline');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->decimal('value')
            ->requirePresence('value', 'create')
            ->greaterThanOrEqual('value', 0.01)
            ->notEmptyString('value');

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->inList('type', ['input', 'output', 'control'])
            ->notEmptyString('type')
            ->add('type', 'output', [
                'rule' => function($value, $context) {
                    if ($value == 'output' && isset($context['data']['expense_category_id'])) {
                        return $context['data']['expense_category_id'] != '';
                    }
                    return true;
                },
                'message' => 'Você deve selecionar a categoria da despesa'
            ]);

        $validator
            ->add('expense_category_id', 'custom', [
                'rule' => function($value, $context) {
                    if($value != '') {
                        $data = TableRegistry::getTableLocator()->get('ExpenseCategories')->get($value);
                        return $data->parent_id !== null;
                    }
                    return true;
                },
                'message' => 'Categoria de transação inválida'
            ]);

        $validator
            ->boolean('confirmation')
            ->allowEmptyString('confirmation');

        $validator
            ->dateTime('confirmation_date')
            ->allowEmptyDateTime('confirmation_date');

        $validator
            ->boolean('removed')
            ->allowEmptyString('removed');

        $validator
            ->dateTime('removed_date')
            ->allowEmptyDateTime('removed_date');

        return $validator;
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findExtract(Query $query, array $options): Query
    {
        return $query
            ->andWhere([
                'Billings.type NOT IN' => 'control',
                'Billings.removed' => false,
            ]);
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findMissedPayments(Query $query, array $options): Query
    {
        return $query
            ->contain(['Companies'])
            ->andWhere([
                'Billings.model' => 'Payments',
//                'Billings.type' => 'control',
                'Billings.removed' => 0,
                'Billings.authorization' => 0,
            ]);
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
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);
        $rules->add($rules->existsIn(['account_id'], 'Accounts'), ['errorField' => 'account_id']);
        $rules->add($rules->existsIn(['partner_id'], 'Partners'), ['errorField' => 'partner_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['expense_category_id'], 'ExpenseCategories'), ['errorField' => 'expense_category_id']);
        $rules->add($rules->existsIn(['confirmation_user_id'], 'ConfirmationUsers'), ['errorField' => 'confirmation_user_id']);
        $rules->add($rules->existsIn(['removed_user_id'], 'RemovedUsers'), ['errorField' => 'removed_user_id']);
        $rules->add($rules->existsIn(['parent_id'], 'ParentBillings'), ['errorField' => 'parent_id']);

        return $rules;
    }

    /**
     * @param Billing $billing
     * @param string $userID
     * @return Billing
     */
    public function removeBilling(Billing $billing, string $userID): Billing
    {
        $billing->removed = true;
        $billing->removed_date = FrozenTime::now();
        $billing->removed_user_id = $userID;

        return $this->saveOrFail($billing);
    }

    /**
     * @param EventInterface $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
//        dd($entity);
//        if ($entity->model == null && isset($entity->partner_id) && strlen($entity->partner_id) != 0) {
//            $entity->model = 'Partners';
//            $entity->foreing_key = $entity->partner_id;
//        }
//
//        if (!$entity->isNew()) {
//            if ($entity->model == 'Partners' && isset($entity->partner_id) && strlen($entity->partner_id) == 0) {
//                $entity->foreing_key = null;
//                $entity->model = null;
//            }
//        }
    }
}
