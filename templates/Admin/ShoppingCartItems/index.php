<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShoppingCartItem[]|\Cake\Collection\CollectionInterface $shoppingCartItems
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('shopping_cart_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('product_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('sale_price') ?></th>
            <th scope="col"><?= $this->Paginator->sort('sale_unit') ?></th>
            <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($shoppingCartItems as $shoppingCartItem) : ?>
            <tr>
                <td><?= $this->Text->truncate($shoppingCartItem->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td><?= $shoppingCartItem->has('shopping_cart') ? $this->Html->link($shoppingCartItem->shopping_cart->id, ['controller' => 'ShoppingCarts', 'action' => 'view', $shoppingCartItem->shopping_cart->id]) : '' ?></td>
                <td><?= $shoppingCartItem->has('product') ? $this->Html->link($shoppingCartItem->product->name, ['controller' => 'Products', 'action' => 'view', $shoppingCartItem->product->id]) : '' ?></td>
                <td><?= $this->Backoffice->currency($shoppingCartItem->sale_price) ?></td>
                <td><?= h($shoppingCartItem->sale_unit) ?></td>
                <td><?= h($shoppingCartItem->amount) ?></td>
                <td><?= h($shoppingCartItem->created) ?></td>
                <td><?= h($shoppingCartItem->modified) ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $shoppingCartItem]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
