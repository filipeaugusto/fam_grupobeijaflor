<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Billing $billing
 * @var \App\Model\Entity\Company[]|\Cake\Collection\CollectionInterface $companies
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="billings form content">
    <?= $this->Form->create($billing) ?>
    <fieldset>
        <legend><?= __('Add Billing') ?></legend>
        <?php
            echo $this->Form->control('company_id', ['options' => $companies]);
//            echo $this->Form->control('model');
//            echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => true, 'required' => true, 'label' => __('Accounts')]);
            echo $this->Form->control('type', ['options' => ['input' => __('Input'), 'output' => __('Output')]]);
            echo $this->Form->control('partner_id', ['options' => $partners, 'class' => 'selectExpenseCategory', 'empty' => true, 'required' => false]);
            echo $this->Form->control('expense_category_id', ['options' => $expenseCategories, 'class' => 'resultExpenseCategory', 'empty' => true, 'required' => false, 'label' => __('Expense Categories')]);
            echo $this->Form->control('deadline', ['empty' => false]);
            echo $this->Form->control('description');
            echo $this->Form->control('value');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
