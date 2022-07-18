<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShoppingCart[]|\Cake\Collection\CollectionInterface $shoppingCarts
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('partner_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('address_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('delivery_date') ?></th>
            <th scope="col"><?= $this->Paginator->sort('observations') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($shoppingCarts as $shoppingCart) : ?>
            <tr>
                <td><?= $this->Text->truncate($shoppingCart->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td><?= $shoppingCart->has('company') ? $this->Html->link($shoppingCart->company->name, ['controller' => 'Companies', 'action' => 'view', $shoppingCart->company->id]) : '' ?></td>
                <td><?= $shoppingCart->has('partner') ? $this->Html->link($shoppingCart->partner->name, ['controller' => 'Partners', 'action' => 'view', $shoppingCart->partner->id]) : '' ?></td>
                <td><?= $shoppingCart->has('user') ? $this->Html->link($shoppingCart->user->name, ['controller' => 'Users', 'action' => 'view', $shoppingCart->user->id]) : '' ?></td>
                <td><?= $shoppingCart->has('address') ? $this->Html->link($shoppingCart->address->name, ['controller' => 'Addresses', 'action' => 'view', $shoppingCart->address->id]) : '' ?></td>
                <td><?= h($shoppingCart->delivery_date) ?></td>
                <td><?= h($shoppingCart->observations) ?></td>
                <td><?= h($shoppingCart->created) ?></td>
                <td><?= h($shoppingCart->modified) ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $shoppingCart]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
