<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExpenseCategory[]|\Cake\Collection\CollectionInterface $expenseCategories
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('name') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($expenseCategories as $expenseCategory) : ?>
        <tr>
            <td><?= $this->Text->truncate($expenseCategory->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
            <td><?= $expenseCategory->has('parent_expense_category') ? $this->Html->link($expenseCategory->parent_expense_category->name, ['controller' => 'ExpenseCategories', 'action' => 'view', $expenseCategory->parent_expense_category->id]) : '' ?></td>
            <td><?= h($expenseCategory->name) ?></td>
            <td><?= h($expenseCategory->created) ?></td>
            <td><?= h($expenseCategory->modified) ?></td>
            <td class="actions">
                <?php echo $this->element('table-actions', ['data' => $expenseCategory]); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
