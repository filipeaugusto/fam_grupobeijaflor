<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FileImport $fileImport
 * @var \App\Model\Entity\Company[]|\Cake\Collection\CollectionInterface $companies
 * @var \App\Model\Entity\CheckControl[]|\Cake\Collection\CollectionInterface $checkControls
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="fileImports form content">
    <?= $this->Form->create($fileImport, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Edit File Import') ?></legend>
        <?php
            echo $this->Form->control('company_id', ['options' => $companies]);
            echo $this->Form->control('archive', ['type' => 'file']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
