<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Billing $billing
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>



<div class="billings view large-9 medium-8 columns content">
    <h3><?= $this->Backoffice->truncate($billing->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($billing->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Company') ?></th>
                <td><?= $billing->has('company') ? $this->Html->link($billing->company->name, ['controller' => 'Companies', 'action' => 'view', $billing->company->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Account') ?></th>
                <td><?= $billing->has('account') ? $this->Html->link($billing->account->details, ['controller' => 'Accounts', 'action' => 'view', $billing->account->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Partner') ?></th>
                <td><?= $billing->has('partner') ? $this->Html->link($billing->partner->name, ['controller' => 'Partners', 'action' => 'view', $billing->partner->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Expense Categories') ?></th>
                <td><?= $billing->has('expense_category') ? $this->Html->link($billing->expense_category->name, ['controller' => 'ExpenseCategories', 'action' => 'view', $billing->expense_category->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('User') ?></th>
                <td><?= $billing->has('user') ? $this->Html->link($billing->user->name, ['controller' => 'Users', 'action' => 'view', $billing->user->id]) : '' ?></td>
            </tr>
            <?php if($billing->foreing_key !== null) { ?>
                <tr>
                    <th scope="row"><?= __('Model') ?></th>
                    <td><?= h($billing->model) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Foreing Key') ?></th>
                    <td><?= $this->Html->link($billing->foreing_key, ['controller' => $billing->model, 'action' => 'view', $billing->foreing_key]) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th scope="row"><?= __('Type') ?></th>
                <td><?= h($billing->type) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Value') ?></th>
                <td><?= $this->Backoffice->currency($billing->value) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Deadline') ?></th>
                <td><?= h($billing->deadline) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Confirmation') ?></th>
                <td><?= $billing->confirmation ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Confirmation User') ?></th>
                <td><?= $billing->has('confirmation_user') ? $this->Html->link($billing->confirmation_user->name, ['controller' => 'Users', 'action' => 'view', $billing->confirmation_user->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Confirmation Date') ?></th>
                <td><?= h($billing->confirmation_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Removed') ?></th>
                <td><?= $billing->removed ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Removed User') ?></th>
                <td><?= $billing->has('removed_user') ? $this->Html->link($billing->removed_user->name, ['controller' => 'Users', 'action' => 'view', $billing->removed_user->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Removed Date') ?></th>
                <td><?= h($billing->removed_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Description') ?></th>
                <td><?= h($billing->description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($billing->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($billing->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <?php if (!empty($billing->orders)): ?>
            <h4><?= __('Related Orders') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Partner') ?></th>
                        <th scope="col"><?= __('User') ?></th>
                        <th scope="col"><?= __('Order Status') ?></th>
                        <th scope="col"><?= __('Delivery Date') ?></th>
                        <th scope="col"><?= __('Observations') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($billing->orders as $orders): //dd($orders); ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($orders->id) ?></td>
                        <td><?= h($orders->partner->name) ?></td>
                        <td><?= h($orders->user->name) ?></td>
                        <td><?= $this->Backoffice->orderStatus($orders->order_status) ?></td>
                        <td><?= h($orders->delivery_date) ?></td>
                        <td><?= h($orders->observations) ?></td>
                        <td><?= h($orders->created) ?></td>
                        <td><?= h($orders->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'Orders', 'data' => $orders]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
