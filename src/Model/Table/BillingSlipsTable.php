<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tickets Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\ExpenseCategoriesTable&\Cake\ORM\Association\BelongsTo $ExpenseCategories
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\BillingSlip newEmptyEntity()
 * @method \App\Model\Entity\BillingSlip newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\BillingSlip[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillingSlip get($primaryKey, $options = [])
 * @method \App\Model\Entity\BillingSlip findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\BillingSlip patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BillingSlip[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillingSlip|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BillingSlip saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BillingSlip[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BillingSlip[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\BillingSlip[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\BillingSlip[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillingSlipsTable extends Table
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
            ->value('expense_category_id')
            ->value('value')
            ->value('type')
            ->value('invoice_number')
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
                        ->andWhere(['BillingSlips.deadline >=' => FrozenTime::now()->subDays((int) $args['limit_deadline'] ?? 30)]);
                }
            ])
            ->add('start_deadline', 'Search.Callback', [
                'callback' => function (Query $query, $args, $filter) {
                    $query
                        ->andWhere(['BillingSlips.deadline >=' => $args['start_deadline']]);
                }
            ])
            ->add('end_deadline', 'Search.Callback', [
                'callback' => function (Query $query, $args, $filter) {
                    $query
                        ->andWhere(['BillingSlips.deadline <=' => $args['end_deadline']]);
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
        $this->belongsTo('Users', [
            'foreignKey' => 'authorization_user_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'confirmation_user_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'removed_user_id',
        ]);
        $this->belongsTo('CreatedUsers', [
            'className' => 'Users',
            'foreignKey' => 'created_user_id',
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
        ]);
        $this->belongsTo('Partners', [
            'foreignKey' => 'partner_id',
        ]);
        $this->belongsTo('ExpenseCategories', [
            'foreignKey' => 'expense_category_id',
        ]);
        $this->belongsTo('CheckControls', [
            'className' => 'CheckControls',
            'foreignKey' => 'foreing_key',
            'conditions' => ['BillingSlips.model' => 'CheckControls']
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'billing_id',
        ]);
        $this->hasMany('Attachments', [
            'foreignKey' => 'foreing_key',
            'conditions' => ['Attachments.model' => 'BillingSlips']
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
            ->scalar('invoice_number')
            ->requirePresence('invoice_number', 'create')
            ->add('invoice_number', 'custom', [
                'rule' => function($value) {
                    return !preg_match('/[^0-9]+/', $value);
                },
                'message' => 'O NR. nota fiscal deve possuir apenas números.'
            ])
            ->notEmptyString('invoice_number');

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
            ->inList('type', ['control'])
            ->notEmptyString('type');

        $validator
            ->boolean('authorization')
            ->allowEmptyString('authorization');

        $validator
            ->dateTime('authorization_date')
            ->allowEmptyDateTime('authorization_date');

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

        $validator
            ->allowEmptyFile('archive')
            ->add('archive', 'extension', [
                'rule' => ['extension', ['csv', 'pdf', 'jpg', 'jpeg', 'png']]
            ]);

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
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);
        $rules->add($rules->existsIn(['account_id'], 'Accounts'), ['errorField' => 'account_id']);
        $rules->add($rules->existsIn(['expense_category_id'], 'ExpenseCategories'), ['errorField' => 'expense_category_id']);
        $rules->add($rules->existsIn(['authorization_user_id'], 'Users'), ['errorField' => 'authorization_user_id']);
        $rules->add($rules->existsIn(['confirmation_user_id'], 'Users'), ['errorField' => 'confirmation_user_id']);
        $rules->add($rules->existsIn(['removed_user_id'], 'Users'), ['errorField' => 'removed_user_id']);

        return $rules;
    }

    /**
     * @param EventInterface $event
     * @param ArrayObject $data
     * @param ArrayObject $options
     */
    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options): void
    {
        $data['authorization'] = $data['authorization'] ?? false;
        $data['type'] = 'control';
    }

    /**
     * @param EventInterface $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->model == null && isset($entity->partner_id) && strlen($entity->partner_id) != 0) {
            $entity->model = 'Partners';
            $entity->foreing_key = $entity->partner_id;
        }

        if (!$entity->isNew()) {
            if ($entity->model == 'Partners' && isset($entity->partner_id) && strlen($entity->partner_id) == 0) {
                $entity->foreing_key = null;
                $entity->model = null;
            }
        }
    }
}
