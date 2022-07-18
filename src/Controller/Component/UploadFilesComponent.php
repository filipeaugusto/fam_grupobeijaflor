<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\Entity;

/**
 * UploadFiles component
 */
class UploadFilesComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'field' => 'image',
        'pathname' => '',
        'filepath' => '',
        'prefix' => 'ARC_'
    ];

    /**
     * @param array $config
     */
    public function initialize(array $config): void
    {
        $this->_defaultConfig = array_merge($config, $this->_defaultConfig);

        $_filepath = WWW_ROOT . 'files' . DS . mb_strtolower($this->_configRead('pathname'));

        if (!file_exists($_filepath)) {
            mkdir($_filepath, 0777, true);
        }

        $this->_configWrite('filepath', $_filepath);

        parent::initialize($this->_defaultConfig);
    }

    /**
     * @param Entity $entity
     */
    public function upload(Entity $entity): void
    {
        $file = $this->getController()->getRequest()->getUploadedFile($this->_configRead('field'));

        if (!$entity->getErrors() && $file->getError() != 4) {
            $this->remove($entity);
            $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
            $entity->{$this->_configRead('field')} = sprintf('%s.%s', uniqid($this->_configRead('prefix')), mb_strtolower($ext));
            $file->moveTo($this->_configRead('filepath') . DS . $entity->{$this->_configRead('field')});
        } else {
            unset($entity->{$this->_configRead('field')});
        }
    }

    /**
     * @param Entity $entity
     */
    public function remove(Entity $entity): void
    {
        if ($entity->getOriginal($this->_configRead('field')) !== null) {
            $filepath = $this->_configRead('filepath') . DS . $entity->getOriginal($this->_configRead('field'));
            if(file_exists($filepath)){
                unlink($filepath);
            }
        }
    }
}
