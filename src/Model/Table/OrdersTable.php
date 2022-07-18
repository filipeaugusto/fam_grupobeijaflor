<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\OrderStatusTable&\Cake\ORM\Association\BelongsTo $OrderStatus
 * @property \App\Model\Table\AddressesTable&\Cake\ORM\Association\BelongsTo $Addresses
 * @property \App\Model\Table\BillingsTable&\Cake\ORM\Association\BelongsTo $Billings
 * @property \App\Model\Table\OrderEvolutionsTable&\Cake\ORM\Association\HasMany $OrderEvolutions
 * @property \App\Model\Table\OrderProductsTable&\Cake\ORM\Association\HasMany $OrderProducts
 * @property \App\Model\Table\AttachmentsTable&\Cake\ORM\Association\HasMany $Attachments
 *
 * @method \App\Model\Entity\Order newEmptyEntity()
 * @method \App\Model\Entity\Order newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Order get($primaryKey, $options = [])
 * @method \App\Model\Entity\Order findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Order[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersTable extends Table
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

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Search.Search');

        $this->searchManager()
            ->value('id')
            ->value('company_id')
            ->value('partner_id')
            ->value('address_id')
            ->value('user_id')
            ->value('order_id')
            ->value('order_status_id')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['id'],
            ]);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Partners', [
            'foreignKey' => 'partner_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('OrderStatus', [
            'foreignKey' => 'order_status_id',
            'joinType' => 'INNER',
            'order' => ['OrderStatus.lft' => 'ASC']
        ]);
        $this->belongsTo('Addresses', [
            'foreignKey' => 'address_id',
        ]);
        $this->belongsTo('Billings', [
            'foreignKey' => 'billing_id',
        ]);
        $this->hasMany('OrderEvolutions', [
            'foreignKey' => 'order_id',
        ]);
        $this->hasMany('OrderProducts', [
            'foreignKey' => 'order_id',
            'order' => ['OrderProducts.removed' => 'ASC']
        ]);
        $this->hasMany('Attachments', [
            'foreignKey' => 'foreing_key',
            'conditions' => ['Attachments.model' => 'Orders']
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
            ->add('order_status_id', 'validState', [
                'rule' => function($value, array $context) {
                    return TableRegistry::getTableLocator()->get('OrderStatus')->get($value)->parent_id !== null;
                },
                'message' => __('This invoice cannot be moved to that status')
            ]);

        $validator
            ->dateTime('delivery_date')
            ->requirePresence('delivery_date', 'create')
            ->notEmptyDateTime('delivery_date');

        $validator
            ->scalar('observations')
            ->allowEmptyString('observations');

        $validator
            ->allowEmptyFile('archive')
            ->add('archive', 'extension', [
                'rule' => ['extension', ['csv', 'pdf', 'jpg', 'jpeg', 'png']]
            ]);

        return $validator;
    }

    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options)
    {
        if (!isset($data['order_status_id'])) {
            $data['order_status_id'] = $this->OrderStatus->first()->id;
        }
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
        $rules->add($rules->existsIn(['partner_id'], 'Partners'), ['errorField' => 'partner_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['order_status_id'], 'OrderStatus'), ['errorField' => 'order_status_id']);
        $rules->add($rules->existsIn(['address_id'], 'Addresses'), ['errorField' => 'address_id']);
        $rules->add($rules->existsIn(['billing_id'], 'Billings'), ['errorField' => 'billing_id']);

        return $rules;
    }
}
