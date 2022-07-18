<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validation;
use Cake\Validation\Validator;

/**
 * Partners Model
 *
 * @property \App\Model\Table\PartnerTypesTable&\Cake\ORM\Association\BelongsTo $PartnerTypes
 * @property \App\Model\Table\CheckControlsTable&\Cake\ORM\Association\HasMany $CheckControls
 * @property \App\Model\Table\ContactsTable&\Cake\ORM\Association\HasMany $Contacts
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\ShoppingCartsTable&\Cake\ORM\Association\HasMany $ShoppingCarts
 * @property \App\Model\Table\AddressesTable&\Cake\ORM\Association\HasOne $Addresses
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsToMany $Categories
 *
 * @method \App\Model\Entity\Partner newEmptyEntity()
 * @method \App\Model\Entity\Partner newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Partner[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Partner get($primaryKey, $options = [])
 * @method \App\Model\Entity\Partner findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Partner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Partner[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Partner|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Partner saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Partner[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Partner[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Partner[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Partner[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PartnersTable extends Table
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

        $this->setTable('partners');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Search.Search');

        $this->searchManager()
            ->add('shop', 'Search.Callback', [
                'callback' => function (Query $query, $args, $filter) {
                    $query->contain('PartnerTypes')
                        ->andWhere(['PartnerTypes.accept_orders' => $args['shop']]);
                }
            ])
            ->value('document')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['name', 'document'],
            ]);

        $this->addBehavior('Timestamp');

        $this->belongsTo('PartnerTypes', [
            'foreignKey' => 'partner_type_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ExpenseCategories', [
            'foreignKey' => 'expense_category_id',
        ]);
        $this->hasMany('CheckControls', [
            'foreignKey' => 'partner_id',
        ]);
        $this->hasMany('Contacts', [
            'foreignKey' => 'partner_id',
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'partner_id',
        ]);
        $this->hasMany('ShoppingCarts', [
            'foreignKey' => 'partner_id',
        ]);
        $this->belongsToMany('Categories', [
            'foreignKey' => 'partner_id',
            'targetForeignKey' => 'category_id',
            'joinTable' => 'categories_partners',
        ]);
        $this->hasOne('Addresses', [
            'foreignKey' => 'foreing_key',
            'conditions' => ['Addresses.model' => 'Partners']
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
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('credit_line')
            ->greaterThanOrEqual('credit_line', 0)
            ->allowEmptyString('credit_line');

        $validator
            ->scalar('document')
            ->maxLength('document', 20)
            ->requirePresence('document', 'create')
            ->notEmptyString('document')
            ->add('document', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmptyFile('image')
            ->uploadedFile('image', [
                'types' => ['image/png', 'image/jpg', 'image/jpeg'],
                'minSize' => 1024, // Min 1 KB
                'maxSize' => 1024 * 1024 // Max 1 MB
            ])
            ->add('image', 'minImageSize', [
                'rule' => ['imageSize', [
                    // Min 10x10 pixel
                    'width' => [Validation::COMPARE_GREATER_OR_EQUAL, 10],
                    'height' => [Validation::COMPARE_GREATER_OR_EQUAL, 10],
                ]]
            ])
            ->add('image', 'maxImageSize', [
                'rule' => ['imageSize', [
                    // Max 500x500 pixel
                    'width' => [Validation::COMPARE_LESS_OR_EQUAL, 500],
                    'height' => [Validation::COMPARE_LESS_OR_EQUAL, 500],
                ]]
            ])
            ->add('image', 'extension', [
                'rule' => ['extension', ['png', 'jpg']]
            ]);

        $validator
            ->scalar('observations')
            ->allowEmptyString('observations');

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
        $rules->add($rules->isUnique(['name']), ['errorField' => 'name']);
        $rules->add($rules->isUnique(['document']), ['errorField' => 'document']);
        $rules->add($rules->existsIn(['partner_type_id'], 'PartnerTypes'), ['errorField' => 'partner_type_id']);
        $rules->add($rules->existsIn(['expense_category_id'], 'ExpenseCategories'), ['errorField' => 'expense_category_id']);

        return $rules;
    }
}
