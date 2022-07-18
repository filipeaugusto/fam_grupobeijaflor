<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validation;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\RulesTable&\Cake\ORM\Association\BelongsTo $Rules
 * @property \App\Model\Table\OrderEvolutionsTable&\Cake\ORM\Association\HasMany $OrderEvolutions
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\ShoppingCartsTable&\Cake\ORM\Association\HasMany $ShoppingCarts
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsToMany $Companies
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Search.Search');

        $this->searchManager()
            ->value('rule_id')
            ->value('phone')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['name', 'username'],
            ]);

        $this->belongsTo('Rules', [
            'foreignKey' => 'rule_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Billings', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('OrderEvolutions', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('ShoppingCarts', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsToMany('Companies', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'company_id',
            'joinTable' => 'companies_users',
        ]);
        $this->hasOne('Addresses', [
            'foreignKey' => 'foreing_key',
            'conditions' => ['Addresses.model' => 'Users']
        ]);
        $this->hasMany('Attachments', [
            'foreignKey' => 'foreing_key',
            'conditions' => ['Attachments.model' => 'Users']
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
            ->scalar('username')
            ->maxLength('username', 150)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->scalar('password')
            ->requirePresence('password', 'create')
            ->maxLength('password', 150)
            ->add('password', [
                    'minLength' => [
                        'rule' => ['minLength', 8],
                        'last' => true,
                        'message' => 'Senha deve possuir ao menos 8 caracteres'
                    ]
                ]
            )
            ->add('password', 'custom', [
                'rule' => function($value) {
                    return preg_match('/[a-zA-Z]+/', $value) && preg_match('/[0-9]+/', $value);
                },
                'message' => 'Senha deve possuir números e letras.'
            ])
            ->notEmptyString('password');

        $validator
            ->add('password_confirm', 'custom', [
                'rule' => function($value, $context) {
                    return $value == $context['data']['password'];
                },
                'message' => 'Senha e confirmação diferentes!'
            ]);

        $validator
            ->scalar('phone')
            ->maxLength('phone', 20)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone');

        $validator
            ->allowEmptyFile('avatar')
            ->uploadedFile('avatar', [
                'types' => ['image/png', 'image/jpg', 'image/jpeg'],
                'minSize' => 1024, // Min 1 KB
                'maxSize' => 1024 * 1024 // Max 1 MB
            ])
            ->add('avatar', 'minImageSize', [
                'rule' => ['imageSize', [
                    // Min 10x10 pixel
                    'width' => [Validation::COMPARE_GREATER_OR_EQUAL, 10],
                    'height' => [Validation::COMPARE_GREATER_OR_EQUAL, 10],
                ]]
            ])
            ->add('avatar', 'maxImageSize', [
                'rule' => ['imageSize', [
                    // Max 750x750 pixel
                    'width' => [Validation::COMPARE_LESS_OR_EQUAL, 750],
                    'height' => [Validation::COMPARE_LESS_OR_EQUAL, 750],
                ]]
            ])
            ->add('avatar', 'extension', [
                'rule' => ['extension', ['png', 'jpg', 'jpeg']]
            ]);

        $validator
            ->scalar('token')
            ->maxLength('token', 50)
            ->allowEmptyString('token');

        $validator
            ->dateTime('token_validity')
            ->allowEmptyDateTime('token_validity');

        $validator
            ->scalar('api_key')
            ->maxLength('api_key', 100)
            ->allowEmptyString('api_key');

        $validator
            ->scalar('api_key_plain')
            ->maxLength('api_key_plain', 100)
            ->allowEmptyString('api_key_plain');

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
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->existsIn(['rule_id'], 'Rules'), ['errorField' => 'rule_id']);

        return $rules;
    }
}
