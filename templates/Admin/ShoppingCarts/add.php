<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('Shop/menu-actions', ['categoires' => $categories, 'partner' => $partner]); ?>

<?php echo $this->element('Shop/sub-menu-actions', ['shoppingCart' => $shoppingCart, 'partner' => $partner]); ?>

<div class="row justify-content-center">
    <?php foreach ($products as $product) { ?>
        <?= $this->element('Shop/card-product', ['product' => $product, 'existing' => in_array($product->id, $shoppingCart->existing_items)]); ?>
    <?php } ?>
</div>

<div class="row mt-5">
    <div class="col-md-4">
        <div class="paginator">
            <?php echo $this->element('pagination'); ?>
        </div>
    </div>
    <div class="col-md-4">

    </div>
    <div class="col-md-4 text-right">
        <?= $this->Html->link(__('{0} Go back', '<i class="bi bi-arrow-left"></i>'), ['controller' => 'partners', 'action' => 'index'], ['class' => 'btn btn-dark', 'escape' => false]); ?>
    </div>
</div>
