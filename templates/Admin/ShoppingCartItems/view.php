<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShoppingCartItem $shoppingCartItem
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="shoppingCartItems view large-9 medium-8 columns content">
    <h3><?= $this->Backoffice->truncate($shoppingCartItem->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($shoppingCartItem->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Shopping Cart') ?></th>
                <td><?= $shoppingCartItem->has('shopping_cart') ? $this->Html->link($shoppingCartItem->shopping_cart->id, ['controller' => 'ShoppingCarts', 'action' => 'view', $shoppingCartItem->shopping_cart->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Product') ?></th>
                <td><?= $shoppingCartItem->has('product') ? $this->Html->link($shoppingCartItem->product->name, ['controller' => 'Products', 'action' => 'view', $shoppingCartItem->product->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Sale Price') ?></th>
                <td><?= $this->Backoffice->currency($shoppingCartItem->sale_price) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Sale Unit') ?></th>
                <td><?= h($shoppingCartItem->sale_unit) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Amount') ?></th>
                <td><?= h($shoppingCartItem->amount) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($shoppingCartItem->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($shoppingCartItem->modified) ?></td>
            </tr>
        </table>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
