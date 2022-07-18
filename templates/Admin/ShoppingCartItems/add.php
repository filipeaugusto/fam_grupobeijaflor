<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShoppingCartItem $shoppingCartItem
 * @var \App\Model\Entity\ShoppingCart[]|\Cake\Collection\CollectionInterface $shoppingCarts
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="shoppingCartItems form content">
    <?= $this->Form->create($shoppingCartItem) ?>
    <fieldset>
        <legend><?= __('Add Shopping Cart Item') ?></legend>
        <?php
            echo $this->Form->control('shopping_cart_id', ['options' => $shoppingCarts]);
            echo $this->Form->control('product_id', ['options' => $products]);
            echo $this->Form->control('sale_price');
            echo $this->Form->control('sale_unit');
            echo $this->Form->control('amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
