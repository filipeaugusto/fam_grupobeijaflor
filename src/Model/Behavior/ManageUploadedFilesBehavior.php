<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Table;

/**
 * ManageUploadedFiles behavior
 */
class ManageUploadedFilesBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'field' => 'image'
    ];

    public function initialize(array $config): void
    {
        $this->_defaultConfig = array_merge($config, $this->_defaultConfig);
        parent::initialize($this->_defaultConfig);
    }


    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->upload($entity);
    }

    private function upload(EntityInterface $entity)
    {
        dd($entity);
    }
}
