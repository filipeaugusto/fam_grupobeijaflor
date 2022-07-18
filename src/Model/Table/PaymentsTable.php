<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Database\StatementInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Payments Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsToMany $Companies
 * @property \App\Model\Table\ExpenseCategoriesTable&\Cake\ORM\Association\BelongsTo $ExpenseCategories
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 *
 * @method \App\Model\Entity\Payment newEmptyEntity()
 * @method \App\Model\Entity\Payment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Payment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Payment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Payment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Payment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Payment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Payment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentsTable extends Table
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

        $this->setTable('payments');
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

        $this->belongsTo('ExpenseCategories', [
            'foreignKey' => 'expense_category_id',
        ]);

        $this->belongsTo('Partners', [
            'foreignKey' => 'partners_id',
        ]);

        $this->belongsToMany('Companies', [
            'foreignKey' => 'payment_id',
            'targetForeignKey' => 'company_id',
            'joinTable' => 'companies_payments',
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
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->decimal('value')
            ->notEmptyString('value');

        $validator
            ->scalar('observations')
            ->requirePresence('observations')
            ->notEmptyString('observations');

        $validator
            ->boolean('repeat_value')
            ->requirePresence('repeat_value');

        $validator
            ->integer('pay_when')
            ->notEmptyString('pay_when');

        $validator
            ->scalar('frequency')
            ->maxLength('frequency', 10)
            ->requirePresence('frequency', 'create')
            ->notEmptyString('frequency');

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
        $rules->add($rules->existsIn(['expense_category_id'], 'ExpenseCategories'), ['errorField' => 'expense_category_id']);
        $rules->add($rules->existsIn(['partner_id'], 'Partners'), ['errorField' => 'partner_id']);

        return $rules;
    }

    /**
     * @return StatementInterface
     */
    public function generate(): StatementInterface
    {
        $sql = <<<SQL
CALL `generatePayments`();
SQL;

        return $this->getConnection()->execute($sql);
    }

    /**
     * @param EventInterface $event
     * @param ArrayObject $data
     * @param ArrayObject $options
     */
    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options): void
    {
        $data['value'] = 0;
        $data['frequency'] = 30;
        $data['type'] = $data['type'] ?? 'output';
    }
}
