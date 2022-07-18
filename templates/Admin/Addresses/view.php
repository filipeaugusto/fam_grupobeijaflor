<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Address $address
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="addresses view large-9 medium-8 columns content">
    <h3><?= h($address->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($address->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Model') ?></th>
                <td><?= h($address->model) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Foreing Key') ?></th>
                <td><?= h($address->foreing_key) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($address->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Address') ?></th>
                <td><?= h($address->address) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Complement') ?></th>
                <td><?= h($address->complement) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Neighbourhood') ?></th>
                <td><?= h($address->neighbourhood) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('City') ?></th>
                <td><?= h($address->city) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('State') ?></th>
                <td><?= h($address->state) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Type') ?></th>
                <td><?= h($address->type) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Number') ?></th>
                <td><?= h($address->number) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Zip Code') ?></th>
                <td><?= $this->Backoffice->zipcode($address->zip_code) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($address->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($address->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <?php if (!empty($address->orders)): ?>
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
                    <?php foreach ($address->orders as $orders): ?>
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
        <?php if (!empty($address->shopping_carts)): ?>
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
                    <?php foreach ($address->shopping_carts as $shoppingCarts): ?>
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
