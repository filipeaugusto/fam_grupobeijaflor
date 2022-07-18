<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 * @var \App\Model\Entity\ParentCompany[]|\Cake\Collection\CollectionInterface $parentCompanies
 * @var \App\Model\Entity\Billing[]|\Cake\Collection\CollectionInterface $billings
 * @var \App\Model\Entity\CheckControl[]|\Cake\Collection\CollectionInterface $checkControls
 * @var \App\Model\Entity\ChildCompany[]|\Cake\Collection\CollectionInterface $childCompanies
 * @var \App\Model\Entity\FileImport[]|\Cake\Collection\CollectionInterface $fileImports
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
 * @var \App\Model\Entity\ShoppingCart[]|\Cake\Collection\CollectionInterface $shoppingCarts
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="companies form content">
    <?= $this->Form->create($company, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Edit Company') ?></legend>
        <?php
            echo $this->Form->control('parent_id', ['options' => $parentCompanies, 'empty' => true]);
            echo $this->Form->control('name');
            echo $this->Form->control('document', ['class' => 'document']);
            echo $this->Form->control('logo', ['type' => 'file']);
            echo $this->Form->control('phone', ['class' => 'phone_with_ddd']);
            echo $this->Form->control('information');
            echo $this->Form->control('payments._ids', ['options' => $payments, 'multiple' => 'checkbox']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
