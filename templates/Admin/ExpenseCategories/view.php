<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExpenseCategory $expenseCategory
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="expenseCategories view large-9 medium-8 columns content">
    <h3><?= h($expenseCategory->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Text->truncate($expenseCategory->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($expenseCategory->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Parent Expense Category') ?></th>
                <td><?= $expenseCategory->has('parent_expense_category') ? $this->Html->link($expenseCategory->parent_expense_category->name, ['controller' => 'ExpenseCategories', 'action' => 'view', $expenseCategory->parent_expense_category->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($expenseCategory->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($expenseCategory->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <?php if (!empty($expenseCategory->billings)): ?>
        <h4><?= __('Related Billings') ?></h4>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Model') ?></th>
                    <th scope="col"><?= __('Foreing Key') ?></th>
                    <th scope="col"><?= __('Deadline') ?></th>
                    <th scope="col"><?= __('Description') ?></th>
                    <th scope="col"><?= __('Value') ?></th>
                    <th scope="col"><?= __('Type') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($expenseCategory->billings as $billings): ?>
                <tr>
                    <td><?= $this->Text->truncate($billings->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                    <td><?= h($billings->model) ?></td>
                    <td><?= h($billings->foreing_key) ?></td>
                    <td><?= h($billings->deadline) ?></td>
                    <td><?= h($billings->description) ?></td>
                    <td><?= h($billings->value) ?></td>
                    <td><?= __($billings->type) ?></td>
                    <td><?= h($billings->created) ?></td>
                    <td class="actions">
                        <?php echo $this->element('table-actions', ['controller' => 'Billings', 'data' => $billings]); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($expenseCategory->child_expense_categories)): ?>
        <h4><?= __('Related Expense Categories') ?></h4>

        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($expenseCategory->child_expense_categories as $childExpenseCategories): ?>
                <tr>
                    <td><?= $this->Text->truncate($childExpenseCategories->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                    <td><?= h($childExpenseCategories->name) ?></td>
                    <td><?= h($childExpenseCategories->created) ?></td>
                    <td><?= h($childExpenseCategories->modified) ?></td>
                    <td class="actions">
                        <?php echo $this->element('table-actions', ['controller' => 'ExpenseCategories', 'data' => $childExpenseCategories]); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($expenseCategory->payments)): ?>
        <h4><?= __('Related Payments') ?></h4>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Value') ?></th>
                    <th scope="col"><?= __('Pay When') ?></th>
                    <th scope="col"><?= __('Frequency') ?></th>
                    <th scope="col"><?= __('Type') ?></th>
                    <th scope="col"><?= __('Removed') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($expenseCategory->payments as $payments): ?>
                <tr>
                    <td><?= $this->Text->truncate($payments->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                    <td><?= h($payments->name) ?></td>
                    <td><?= h($payments->value) ?></td>
                    <td><?= h($payments->pay_when) ?></td>
                    <td><?= h($payments->frequency) ?></td>
                    <td><?= __($payments->type) ?></td>
                    <td><?= h($payments->removed) ?></td>
                    <td><?= h($payments->created) ?></td>
                    <td class="actions">
                        <?php echo $this->element('table-actions', ['controller' => 'Payments', 'data' => $payments]); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
