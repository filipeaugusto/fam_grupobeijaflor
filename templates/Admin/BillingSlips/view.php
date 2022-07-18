<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Billing $billingSlip
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="billings view large-9 medium-8 columns content">
    <h3><?= $this->Backoffice->truncate($billingSlip->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($billingSlip->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Company') ?></th>
                <td><?= $billingSlip->has('company') ? $this->Html->link($billingSlip->company->name, ['controller' => 'Companies', 'action' => 'view', $billingSlip->company->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Account') ?></th>
                <td><?= $billingSlip->has('account') ? $this->Html->link($billingSlip->account->details, ['controller' => 'Accounts', 'action' => 'view', $billingSlip->account->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Partner') ?></th>
                <td><?= $billingSlip->has('partner') ? $this->Html->link($billingSlip->partner->name, ['controller' => 'Partners', 'action' => 'view', $billingSlip->partner->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Expense Categories') ?></th>
                <td><?= $billingSlip->has('expense_category') ? $this->Html->link($billingSlip->expense_category->name, ['controller' => 'ExpenseCategories', 'action' => 'view', $billingSlip->expense_category->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('User') ?></th>
                <td><?= $billingSlip->has('user') ? $this->Html->link($billingSlip->user->name, ['controller' => 'Users', 'action' => 'view', $billingSlip->user->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created User') ?></th>
                <td><?= $billingSlip->has('created_user') ? $this->Html->link($billingSlip->created_user->name, ['controller' => 'Users', 'action' => 'view', $billingSlip->created_user->id]) : '' ?></td>
            </tr>
            <?php if($billingSlip->foreing_key !== null) { ?>
                <tr>
                    <th scope="row"><?= __('Model') ?></th>
                    <td><?= h($billingSlip->model) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Foreing Key') ?></th>
                    <td><?= $this->Html->link($billingSlip->foreing_key, ['controller' => $billingSlip->model, 'action' => 'view', $billingSlip->foreing_key]) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th scope="row"><?= __('Invoice number') ?></th>
                <td><?= h($billingSlip->invoice_number) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Type') ?></th>
                <td><?= h($billingSlip->type) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Value') ?></th>
                <td><?= $this->Backoffice->currency($billingSlip->value) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Archive') ?></th>
                <td><?= $this->Backoffice->archive($billingSlip->archive) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Deadline') ?></th>
                <td><?= h($billingSlip->deadline) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Confirmation') ?></th>
                <td><?= $billingSlip->confirmation ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Confirmation User Id') ?></th>
                <td><?= $this->Backoffice->truncate($billingSlip->confirmation_user_id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Confirmation Date') ?></th>
                <td><?= h($billingSlip->confirmation_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Removed') ?></th>
                <td><?= $billingSlip->removed ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Removed Date') ?></th>
                <td><?= h($billingSlip->removed_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Description') ?></th>
                <td><?= h($billingSlip->description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Archive') ?></th>
                <td><?= $this->Backoffice->archive($billingSlip->archive, ['alt' => $billingSlip->description, 'title' => $billingSlip->description]) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($billingSlip->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($billingSlip->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <?php if (!empty($billingSlip->orders)): ?>
            <h4><?= __('Related Orders') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Company Id') ?></th>
                        <th scope="col"><?= __('Partner Id') ?></th>
                        <th scope="col"><?= __('User Id') ?></th>
                        <th scope="col"><?= __('Order Status Id') ?></th>
                        <th scope="col"><?= __('Address Id') ?></th>
                        <th scope="col"><?= __('Billing Id') ?></th>
                        <th scope="col"><?= __('Delivery Date') ?></th>
                        <th scope="col"><?= __('Observations') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($billingSlip->orders as $orders): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($orders->id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->company_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->partner_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->user_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->order_status_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->address_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->billing_id) ?></td>
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
