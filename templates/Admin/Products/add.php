<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 * @var \App\Model\Entity\OrderProduct[]|\Cake\Collection\CollectionInterface $orderProducts
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="products form content">
    <?= $this->Form->create($product, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Add Product') ?></legend>
        <?php
            echo $this->Form->control('category_id', ['options' => $categories]);
            echo $this->Form->control('name');
            echo $this->Form->control('code');
            echo $this->Form->control('image', ['type' => 'file']);
            echo $this->Form->control('information');
//            echo $this->Form->control('store_stock');
//            echo $this->Form->control('reserve_stock');
//            echo $this->Form->control('history_price');
//            echo $this->Form->control('validate_stock');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
