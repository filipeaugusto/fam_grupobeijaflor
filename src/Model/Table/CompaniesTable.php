<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validation;
use Cake\Validation\Validator;

/**
 * Companies Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $ParentCompanies
 * @property \App\Model\Table\BillingsTable&\Cake\ORM\Association\HasMany $Billings
 * @property \App\Model\Table\CheckControlsTable&\Cake\ORM\Association\HasMany $CheckControls
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\HasMany $ChildCompanies
 * @property \App\Model\Table\FileImportsTable&\Cake\ORM\Association\HasMany $FileImports
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\PaymentsTable&\Cake\ORM\Association\HasMany $Payments
 * @property \App\Model\Table\ShoppingCartsTable&\Cake\ORM\Association\HasMany $ShoppingCarts
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 * @property \App\Model\Table\AccountsTable&\Cake\ORM\Association\HasMany $Accounts
 * @property \App\Model\Table\AddressesTable&\Cake\ORM\Association\HasOne $Addresses
 *
 * @method \App\Model\Entity\Company newEmptyEntity()
 * @method \App\Model\Entity\Company newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Company[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Company get($primaryKey, $options = [])
 * @method \App\Model\Entity\Company findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Company patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Company[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Company|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Company saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class CompaniesTable extends Table
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

        $this->setTable('companies');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Search.Search');

        $this->searchManager()
            ->value('document')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['name', 'information'],
            ]);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('ParentCompanies', [
            'className' => 'Companies',
            'foreignKey' => 'parent_id',
            'conditions' => ['ParentCompanies.parent_id IS NULL'],
            'order' => ['ParentCompanies.lft' => 'ASC']
        ]);
        $this->hasMany('Billings', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('CheckControls', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('ChildCompanies', [
            'className' => 'Companies',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('FileImports', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('ShoppingCarts', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasMany('Accounts', [
            'foreignKey' => 'company_id',
        ]);
        $this->hasOne('Addresses', [
            'foreignKey' => 'foreing_key',
            'conditions' => ['Addresses.model' => 'Companies']
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'company_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'companies_users',
        ]);
        $this->belongsToMany('Payments', [
            'foreignKey' => 'company_id',
            'targetForeignKey' => 'payment_id',
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
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('document')
            ->maxLength('document', 20)
            ->requirePresence('document', 'create')
            ->notEmptyString('document')
            ->add('document', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmptyFile('logo')
            ->uploadedFile('logo', [
                'types' => ['image/png', 'image/jpg', 'image/jpeg'],
                'minSize' => 1024, // Min 1 KB
                'maxSize' => 1024 * 1024 // Max 1 MB
            ])
            ->add('logo', 'minImageSize', [
                'rule' => ['imageSize', [
                    // Min 10x10 pixel
                    'width' => [Validation::COMPARE_GREATER_OR_EQUAL, 10],
                    'height' => [Validation::COMPARE_GREATER_OR_EQUAL, 10],
                ]]
            ])
            ->add('logo', 'maxImageSize', [
                'rule' => ['imageSize', [
                    // Max 500x500 pixel
                    'width' => [Validation::COMPARE_LESS_OR_EQUAL, 500],
                    'height' => [Validation::COMPARE_LESS_OR_EQUAL, 500],
                ]]
            ])
            ->add('logo', 'extension', [
                'rule' => ['extension', ['png', 'jpg']]
            ]);

        $validator
            ->scalar('phone')
            ->maxLength('phone', 20)
            ->allowEmptyString('phone');

        $validator
            ->scalar('information')
            ->allowEmptyString('information');

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
        $rules->add($rules->isUnique(['document']), ['errorField' => 'document']);
        $rules->add($rules->isUnique(['name']), ['errorField' => 'name']);
        $rules->add($rules->existsIn(['parent_id'], 'ParentCompanies'), ['errorField' => 'parent_id']);

        return $rules;
    }
}
