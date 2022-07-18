<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExpenseCategory $expenseCategory
 * @var \App\Model\Entity\ParentExpenseCategory[]|\Cake\Collection\CollectionInterface $parentExpenseCategories
 * @var \App\Model\Entity\Billing[]|\Cake\Collection\CollectionInterface $billings
 * @var \App\Model\Entity\ChildExpenseCategory[]|\Cake\Collection\CollectionInterface $childExpenseCategories
 * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="expenseCategories form content">
    <?= $this->Form->create($expenseCategory) ?>
    <fieldset>
        <legend><?= __('Edit Expense Category') ?></legend>
        <?php
            echo $this->Form->control('parent_id', ['options' => $parentExpenseCategories, 'empty' => true]);
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
