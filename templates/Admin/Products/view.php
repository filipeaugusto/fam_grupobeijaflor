<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="products view large-9 medium-8 columns content">
    <h3><?= h($product->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($product->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Category') ?></th>
                <td><?= $product->has('category') ? $this->Html->link($product->category->name, ['controller' => 'Categories', 'action' => 'view', $product->category->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($product->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Code') ?></th>
                <td><?= h($product->code) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Image') ?></th>
                <td>
                    <?= $this->Backoffice->archive($product->image, ['alt' => $product->name, 'title' => $product->name, 'width' => '150px']) ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Store Stock') ?></th>
                <td><?= h($product->store_stock) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Reserve Stock') ?></th>
                <td><?= h($product->reserve_stock) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Validate Stock') ?></th>
                <td><?= $product->validate_stock ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('History Price') ?></th>
                <td><?= $this->Backoffice->currency($product->history_price) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('information') ?></th>
                <td><?= h($product->information) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($product->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($product->modified) ?></td>
            </tr>
        </table>
    </div>

    <div class="related">
        <?php if (!empty($product->order_products)): ?>
            <h4><?= __('Related Order Products') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Order Id') ?></th>
                        <th scope="col"><?= __('Product Id') ?></th>
                        <th scope="col"><?= __('Sale Price') ?></th>
                        <th scope="col"><?= __('Sale Unit') ?></th>
                        <th scope="col"><?= __('Amount') ?></th>
                        <th scope="col"><?= __('Removed') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($product->order_products as $orderProducts): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($orderProducts->id) ?></td>
                        <td><?= $this->Backoffice->truncate($orderProducts->order_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orderProducts->product_id) ?></td>
                        <td><?= h($orderProducts->sale_price) ?></td>
                        <td><?= h($orderProducts->sale_unit) ?></td>
                        <td><?= h($orderProducts->amount) ?></td>
                        <td><?= h($orderProducts->removed) ?></td>
                        <td><?= h($orderProducts->created) ?></td>
                        <td><?= h($orderProducts->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'OrderProducts', 'data' => $orderProducts]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
