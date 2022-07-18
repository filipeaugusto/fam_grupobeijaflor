<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="users view large-9 medium-8 columns content">
    <div class="row">
        <div class="col-sm-12 col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <?= $this->Backoffice->archive($user->avatar, ['alt' => $user->name, 'title' => $user->name, 'width' => '150px', 'class' => 'rounded-circle']) ?>
                        <div class="mt-3">
                            <h4><?= h($user->name) ?></h4>
                            <p class="text-secondary mb-1"><?= h($user->rule->name); ?></p>
                            <?= $this->Html->link(__('{0} Edit', '<i class="bi bi-pencil-square"></i>'), ['action' => 'edit', $user->id], ['title' => __('Edit'), 'class' => 'btn btn-info', 'escape' => false]) ?>
                            <button class="btn btn-outline-primary">Message</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-8 mb-3">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Backoffice->truncate($user->id) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Rule') ?></th>
                        <td><?= $user->has('rule') ? $this->Html->link($user->rule->name, ['controller' => 'Rules', 'action' => 'view', $user->rule->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($user->name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Username') ?></th>
                        <td><?= h($user->username) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Phone') ?></th>
                        <td><?= $this->Backoffice->phone($user->phone) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($user->created) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($user->modified) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="related">
        <?php if (!empty($user->companies)): ?>
            <h4><?= __('Related Companies') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($user->companies as $company): ?>
                        <tr>
                            <td><?= $this->Backoffice->truncate($company->id) ?></td>
                            <td><?= h($company->name) ?></td>
                            <td><?= h($company->created) ?></td>
                            <td><?= h($company->modified) ?></td>
                            <td class="actions">
                                <?php echo $this->element('table-actions', ['controller' => 'Companies', 'data' => $company]); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div class="related">
        <?php if (!empty($user->order_evolutions)): ?>
            <h4><?= __('Related Order Evolutions') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('User Id') ?></th>
                        <th scope="col"><?= __('Order Id') ?></th>
                        <th scope="col"><?= __('Order Status Id') ?></th>
                        <th scope="col"><?= __('Date Start') ?></th>
                        <th scope="col"><?= __('Date End') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($user->order_evolutions as $orderEvolutions): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($orderEvolutions->id) ?></td>
                        <td><?= $this->Backoffice->truncate($orderEvolutions->user_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orderEvolutions->order_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orderEvolutions->order_status_id) ?></td>
                        <td><?= h($orderEvolutions->date_start) ?></td>
                        <td><?= h($orderEvolutions->date_end) ?></td>
                        <td><?= h($orderEvolutions->created) ?></td>
                        <td><?= h($orderEvolutions->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'OrderEvolutions', 'data' => $orderEvolutions]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div class="related">
        <?php if (!empty($user->orders)): ?>
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
                    <?php foreach ($user->orders as $orders): ?>
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
    <div class="related">
        <?php if (!empty($user->shopping_carts)): ?>
            <h4><?= __('Related Shopping Carts') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Company Id') ?></th>
                        <th scope="col"><?= __('Partner Id') ?></th>
                        <th scope="col"><?= __('User Id') ?></th>
                        <th scope="col"><?= __('Address Id') ?></th>
                        <th scope="col"><?= __('Delivery Date') ?></th>
                        <th scope="col"><?= __('Observations') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($user->shopping_carts as $shoppingCarts): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($shoppingCarts->id) ?></td>
                        <td><?= $this->Backoffice->truncate($shoppingCarts->company_id) ?></td>
                        <td><?= $this->Backoffice->truncate($shoppingCarts->partner_id) ?></td>
                        <td><?= $this->Backoffice->truncate($shoppingCarts->user_id) ?></td>
                        <td><?= $this->Backoffice->truncate($shoppingCarts->address_id) ?></td>
                        <td><?= h($shoppingCarts->delivery_date) ?></td>
                        <td><?= h($shoppingCarts->observations) ?></td>
                        <td><?= h($shoppingCarts->created) ?></td>
                        <td><?= h($shoppingCarts->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'ShoppingCarts', 'data' => $shoppingCarts]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
