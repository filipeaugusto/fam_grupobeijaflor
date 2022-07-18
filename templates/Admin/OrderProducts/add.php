<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderProduct $orderProduct
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="orderProducts form content">
    <?= $this->Form->create($orderProduct) ?>
    <fieldset>
        <legend><?= __('Add Order Product') ?></legend>
        <?php
            echo $this->Form->control('order_id', ['options' => $orders]);
            echo $this->Form->control('product_id', ['options' => $products]);
            echo $this->Form->control('sale_price');
            echo $this->Form->control('sale_unit');
            echo $this->Form->control('amount');
            echo $this->Form->control('removed');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
