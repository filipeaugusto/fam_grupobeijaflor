<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\OrderStatus;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderStatus Model
 *
 * @property \App\Model\Table\OrderStatusTable&\Cake\ORM\Association\BelongsTo $ParentOrderStatus
 * @property \App\Model\Table\OrderEvolutionsTable&\Cake\ORM\Association\HasMany $OrderEvolutions
 * @property \App\Model\Table\OrderStatusTable&\Cake\ORM\Association\HasMany $ChildOrderStatus
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\OrderStatus newEmptyEntity()
 * @method \App\Model\Entity\OrderStatus newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OrderStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderStatus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OrderStatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderStatus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderStatus|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderStatus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderStatus[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderStatus[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderStatus[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OrderStatus[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class OrderStatusTable extends Table
{

    const TYPE_PROCESS = 'process';
    const TYPE_CANCEL = 'cancel';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('order_status');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Search.Search');

        $this->searchManager()
            ->value('parent_id')
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

        $this->belongsTo('ParentOrderStatus', [
            'className' => 'OrderStatus',
            'foreignKey' => 'parent_id',
            'conditions' => ['ParentOrderStatus.parent_id IS NULL'],
            'order' => ['ParentOrderStatus.lft' => 'ASC']
        ]);
        $this->hasMany('OrderEvolutions', [
            'foreignKey' => 'order_status_id',
        ]);
        $this->hasMany('ChildOrderStatus', [
            'className' => 'OrderStatus',
            'foreignKey' => 'parent_id',
            'order' => ['ChildOrderStatus.lft' => 'ASC']
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'order_status_id',
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
            ->scalar('background_color')
            ->maxLength('background_color', 7)
            ->notEmptyString('background_color');

        $validator
            ->scalar('font_color')
            ->maxLength('font_color', 7)
            ->notEmptyString('font_color');

        $validator
            ->boolean('active')
            ->notEmptyString('active');

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->inList('type', ['process', 'cancel'])
            ->add('type', 'custom', ['rule' => function($value, $context) {
                if ($value === self::TYPE_CANCEL) {
                    $query = $this->find('all')
                        ->where(['active' => true, 'type' => 'cancel']);
                    if (!$context['newRecord']) {
                        $query->andWhere(['id NOT IN' => $context['data']['id']]);
                    }
                    return $query->count() == 0;
                }
                return true;
            }, 'message' => __('A cancellation status has already been set')])
            ->notEmptyString('type');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentOrderStatus'), ['errorField' => 'parent_id']);

        return $rules;
    }

    /**
     * @return array|\Cake\Datasource\EntityInterface
     */
    public function first(): ?OrderStatus
    {
        return $this->find('all')
            ->where(['active' => true, 'type' => 'process'])
            ->whereNotNull(['parent_id'])
            ->orderAsc('lft')
            ->firstOrFail();
    }

    /**
     * @param OrderStatus $orderStatus
     * @return array|\Cake\Datasource\EntityInterface
     */
    public function next(OrderStatus $orderStatus): ?OrderStatus
    {
        return $this->find('all')
            ->where(['active' => true, 'type' => 'process', 'lft >' => $orderStatus->lft])
            ->whereNotNull(['parent_id'])
            ->orderAsc('lft')
            ->firstOrFail();
    }

    /**
     * @param OrderStatus $orderStatus
     * @return array|\Cake\Datasource\EntityInterface
     */
    public function previous(OrderStatus $orderStatus): ?OrderStatus
    {
        return $this->find('all')
            ->where(['active' => true, 'type' => 'process', 'lft <' => $orderStatus->lft])
            ->whereNotNull(['parent_id'])
            ->orderDesc('lft')
            ->firstOrFail();
    }

    /**
     * @return OrderStatus|array|\Cake\Datasource\EntityInterface
     */
    public function last(): ?OrderStatus
    {
        return $this->find('all')
            ->where(['active' => true, 'type' => 'process'])
            ->whereNotNull(['parent_id'])
            ->orderDesc('lft')
            ->firstOrFail();
    }

    /**
     * @return OrderStatus|array|\Cake\Datasource\EntityInterface
     */
    public function cancel(): ?OrderStatus
    {
        return $this->find('all')
            ->where(['active' => true, 'type' => 'cancel'])
            ->whereNotNull(['parent_id'])
            ->orderDesc('lft')
            ->firstOrFail();
    }

}
