<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 * @var \App\Model\Entity\Company[]|\Cake\Collection\CollectionInterface $companies
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="payments form content">
    <?= $this->Form->create($payment) ?>
    <fieldset>
        <legend><?= __('Add Payment') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('observations');
            echo $this->Form->control('repeat_value',  ['options' => [__('No'), __('Yes')]]);
//            echo $this->Form->control('value');
            echo $this->Form->control('pay_when');
//            echo $this->Form->control('frequency');
            echo $this->Form->control('type', ['default' => 'output', 'options' => ['control' => __('Control'), 'input' => __('Input'), 'output' => __('Output')]]);
            echo $this->Form->control('partner_id', ['options' => $partners, 'class' => 'selectExpenseCategory', 'empty' => true, 'required' => false]);
            echo $this->Form->control('expense_category_id', ['options' => $expenseCategories, 'empty' => true, 'class' => 'resultExpenseCategory', 'required' => false, 'label' => __('Expense Categories')]);
            echo $this->Form->control('companies._ids', ['options' => $companies, 'multiple' => 'checkbox']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
