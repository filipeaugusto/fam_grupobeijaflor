<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Partner $partner
 * @var \App\Model\Entity\PartnerType[]|\Cake\Collection\CollectionInterface $partnerTypes
 * @var \App\Model\Entity\CheckControl[]|\Cake\Collection\CollectionInterface $checkControls
 * @var \App\Model\Entity\Contact[]|\Cake\Collection\CollectionInterface $contacts
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 * @var \App\Model\Entity\ShoppingCart[]|\Cake\Collection\CollectionInterface $shoppingCarts
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="partners form content">
    <?= $this->Form->create($partner, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Add Partner') ?></legend>
        <?php
        echo $this->Form->control('partner_type_id', ['options' => $partnerTypes]);
        echo $this->Form->control('name');
        echo $this->Form->control('document', ['class' => 'document']);
        echo $this->Form->control('image', ['type' => 'file']);
        echo $this->Form->control('credit_line');
        echo $this->Form->control('observations');
        echo $this->Form->control('expense_category_id', ['options' => $expenseCategories, 'empty' => true, 'label' => 'Categoria de transação principal']);
        echo $this->Form->control('categories._ids', ['options' => $categories, 'multiple' => 'checkbox']);
//        echo $this->element('Forms/contacts');
//        echo $this->Form->control('active');
//        echo $this->element('Forms/adresses');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
