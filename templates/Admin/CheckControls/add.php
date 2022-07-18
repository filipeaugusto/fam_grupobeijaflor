<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CheckControl $checkControl
 * @var \App\Model\Entity\Company[]|\Cake\Collection\CollectionInterface $companies
 * @var \App\Model\Entity\FileImport[]|\Cake\Collection\CollectionInterface $fileImports
 * @var \App\Model\Entity\Partner[]|\Cake\Collection\CollectionInterface $partners
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="checkControls form content">
    <?= $this->Form->create($checkControl) ?>
    <fieldset>
        <legend><?= __('Add Check Control') ?></legend>
        <?php
            echo $this->Form->control('company_id', ['options' => $companies]);
            echo $this->Form->control('document', ['class' => 'document']);
            echo $this->Form->control('bank');
            echo $this->Form->control('agency');
            echo $this->Form->control('account');
            echo $this->Form->control('number');
            echo $this->Form->control('value');
            echo $this->Form->control('deadline');
            echo $this->Form->control('description');
//            echo $this->Form->control('confirmation');
//            echo $this->Form->control('confirmation_user_id');
//            echo $this->Form->control('confirmation_date', ['empty' => true]);
//            echo $this->Form->control('destination');
//            echo $this->Form->control('destination_user_id', ['options' => $users, 'empty' => true]);
//            echo $this->Form->control('destination_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
