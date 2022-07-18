<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Billing $billingSlip
 * @var \App\Model\Entity\Company[]|\Cake\Collection\CollectionInterface $companies
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="billings form content">
    <?= $this->Form->create($billingSlip, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Add Billing') ?></legend>
        <?php
            echo $this->Form->control('company_id', ['options' => $companies]);
//            echo $this->Form->control('type', ['default' => 'control', 'options' => ['control' => __('Control')]]);
            echo $this->Form->control('partner_id', ['options' => $partners, 'empty' => true, 'required' => false, 'class' => 'selectExpenseCategory']);
            echo $this->Form->control('expense_category_id', ['options' => $expenseCategories, 'empty' => true, 'class' => 'resultExpenseCategory', 'required' => false, 'label' => __('Expense Categories')]);
            echo $this->Form->control('deadline', ['empty' => true]);
            echo $this->Form->control('invoice_number', ['empty' => false, 'required' => true]);
            echo $this->Form->control('description');
            echo $this->Form->control('archive', ['type' => 'file']);
            echo $this->Form->control('value');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
