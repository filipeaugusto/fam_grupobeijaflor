<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CheckControls Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\FileImportsTable&\Cake\ORM\Association\BelongsTo $FileImports
 * @property \App\Model\Table\PartnersTable&\Cake\ORM\Association\BelongsTo $Partners
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\BillingsTable&\Cake\ORM\Association\HasOne $Billings
// * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\CheckControl newEmptyEntity()
 * @method \App\Model\Entity\CheckControl newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CheckControl[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CheckControl get($primaryKey, $options = [])
 * @method \App\Model\Entity\CheckControl findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CheckControl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CheckControl[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CheckControl|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CheckControl saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CheckControl[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CheckControl[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CheckControl[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CheckControl[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CheckControlsTable extends Table
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

        $this->setTable('check_controls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Search.Search');

        $this->searchManager()
            ->value('company_id')
            ->value('partner_id')
            ->value('bank')
            ->value('agency')
            ->value('account')
            ->value('number')
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['id', 'description', 'document', 'number'],
            ]);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('FileImports', [
            'foreignKey' => 'file_import_id',
        ]);
        $this->belongsTo('Partners', [
            'foreignKey' => 'partner_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'confirmation_user_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'destination_user_id',
        ]);
        $this->hasMany('Billings', [
            'foreignKey' => 'foreing_key',
            'conditions' => [
                'Billings.model' => 'CheckControls',
            ]
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
            ->scalar('document')
            ->maxLength('document', 20)
            ->requirePresence('document', 'create')
            ->notEmptyString('document');

        $validator
            ->scalar('bank')
            ->maxLength('bank', 5)
            ->requirePresence('bank', 'create')
            ->notEmptyString('bank');

        $validator
            ->scalar('agency')
            ->maxLength('agency', 20)
            ->requirePresence('agency', 'create')
            ->notEmptyString('agency');

        $validator
            ->scalar('account')
            ->maxLength('account', 20)
            ->requirePresence('account', 'create')
            ->notEmptyString('account');

        $validator
            ->scalar('number')
            ->maxLength('number', 20)
            ->requirePresence('number', 'create')
            ->notEmptyString('number');

        $validator
            ->decimal('value')
            ->notEmptyString('value');

        $validator
            ->date('deadline')
            ->requirePresence('deadline', 'create')
            ->notEmptyDate('deadline');

        $validator
            ->date('deposit_date')
            ->allowEmptyDateTime('deposit_date');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->boolean('confirmation')
            ->allowEmptyString('confirmation');

        $validator
            ->dateTime('confirmation_date')
            ->allowEmptyDateTime('confirmation_date');

        $validator
            ->boolean('destination')
            ->allowEmptyString('destination');

        $validator
            ->dateTime('destination_date')
            ->allowEmptyDateTime('destination_date');

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
        $rules->add($rules->existsIn(['file_import_id'], 'FileImports'), ['errorField' => 'file_import_id']);
        $rules->add($rules->existsIn(['partner_id'], 'Partners'), ['errorField' => 'partner_id']);
        $rules->add($rules->existsIn(['confirmation_user_id'], 'Users'), ['errorField' => 'confirmation_user_id']);
        $rules->add($rules->existsIn(['destination_user_id'], 'Users'), ['errorField' => 'destination_user_id']);

        return $rules;
    }


    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options)
    {
        if (isset($data['document'])) {
            try {
                $partner = $this->Partners
                    ->findByDocument(preg_replace('/[^0-9]/', '', $data['document']))
                    ->firstOrFail();

                $data['partner_id'] = $partner->id;

            } catch (RecordNotFoundException $e) {
                $data['partner_id'] = null;
            }
        }
    }
}
