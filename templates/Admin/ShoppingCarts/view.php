<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('Shop/menu-actions', ['categoires' => $categories, 'partner' => $shoppingCart->partner]); ?>

<?php echo $this->element('Shop/sub-menu-actions', ['shoppingCart' => $shoppingCart, 'partner' => $shoppingCart->partner]); ?>


<div class="shoppingCarts view large-9 medium-8 columns content">
    <div class="row">
        <div class="col-sm-12 col-md-4 mb-3">
            <div class="card border-0">
                <div class="card-header card-2">
                    <p class="card-text text-muted mt-md-4 mb-2 space">CHECKOUT <span class=" small text-muted ml-2 cursor-pointer">SHIPPING DETAILS</span> </p>
                    <hr class="my-2">
                </div>
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-auto mt-0">
                            <p><b><?= h($shoppingCart->partner->name); ?></b></p>
                        </div>
                        <div class="col-auto">
                            <p><b><?= $this->Backoffice->document($shoppingCart->partner->document); ?></b> </p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <p class="text-muted mb-2">PAYMENT DETAILS</p>
                            <hr class="mt-0">
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-auto mt-0">
                            <p><b><?= __('Quantity products'); ?></b></p>
                        </div>
                        <div class="col-auto">
                            <p><b><?= h($shoppingCart->quantity_products); ?></b> </p>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-auto mt-0">
                            <p><b><?= __('Quantity items'); ?></b></p>
                        </div>
                        <div class="col-auto">
                            <p><b><?= h($shoppingCart->quantity_items); ?></b> </p>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-auto mt-0">
                            <p><b><?= __('Total order'); ?></b></p>
                        </div>
                        <div class="col-auto">
                            <p><b><?= $this->Backoffice->currency($shoppingCart->total_order); ?></b> </p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <p class="text-muted mb-2">DELIVERY INFORMATION</p>
                            <hr class="mt-0">
                        </div>
                    </div>
                    <?= $this->Form->create($shoppingCart, ['url' => ['action' => 'createOrder', $shoppingCart->id]]) ?>
                        <?= $this->Form->control('delivery_date', ['required' => true, 'label' => false]); ?>
                        <div class="row mb-md-5">
                            <div class="col">
                                <button type="<?= $shoppingCart->existing_items ? 'submit' : 'reset' ?>" name="" id="" class="btn btn-lg btn-block btn-outline-info">
                                    <?= __('PURCHASE'); ?>
                                </button>
                            </div>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-8 mb-3">

            <h3><?= $this->Backoffice->truncate($shoppingCart->id) ?></h3>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="row"><?= __('Company') ?></th>
                        <td><?= $shoppingCart->has('company') ? $this->Html->link($shoppingCart->company->name, ['controller' => 'Companies', 'action' => 'view', $shoppingCart->company->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Partner') ?></th>
                        <td><?= $shoppingCart->has('partner') ? $this->Html->link($shoppingCart->partner->name, ['controller' => 'Partners', 'action' => 'view', $shoppingCart->partner->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('User') ?></th>
                        <td><?= $shoppingCart->has('user') ? $this->Html->link($shoppingCart->user->name, ['controller' => 'Users', 'action' => 'view', $shoppingCart->user->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Address') ?></th>
                        <td><?= $shoppingCart->has('address') ? $this->Html->link($shoppingCart->address->name, ['controller' => 'Addresses', 'action' => 'view', $shoppingCart->address->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Delivery Date') ?></th>
                        <td><?= h($shoppingCart->delivery_date) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($shoppingCart->created) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="related">
        <div class="card border-0">
            <div class="card-header">
                <p class="card-text text-muted mt-md-4 mb-2 space">YOUR ORDER <span class=" small text-muted ml-2 cursor-pointer">EDIT SHOPPING BAG</span> </p>
                <hr class="my-2">
            </div>
        </div>

        <?php if (!empty($shoppingCart->shopping_cart_items)): ?>
            <div class="table-responsives">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Image') ?></th>
                        <th scope="col"><?= __('Product') ?></th>
                        <th scope="col"><?= __('History price') ?></th>
                        <th scope="col"><?= __('Amount') ?></th>
                        <th scope="col"><?= __('Sale Price') ?></th>
                        <th scope="col"><?= __('Price Total') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($shoppingCart->shopping_cart_items as $shoppingCartItems): ?>
                    <tr>
                        <td>
                            <?= $this->Backoffice->archive($shoppingCartItems->product->image, ['folder' => 'products', 'alt' => $shoppingCartItems->product->name, 'title' => $shoppingCartItems->product->name, 'width' => '45px']) ?>
                        </td>
                        <td><?= $this->Backoffice->truncate($shoppingCartItems->product->name) ?></td>
                        <td class="text-info"><?= $this->Backoffice->currency($shoppingCartItems->product->history_price) ?></td>
                        <td><?= h($shoppingCartItems->amount) ?></td>
                        <td>
                            <?= $this->Html->tag('i', null, ['class' => $shoppingCartItems->status_emoji]) ?>
                            <?= $this->Backoffice->currency($shoppingCartItems->sale_price) ?>
                        </td>
                        <td><?= $this->Backoffice->currency($shoppingCartItems->total_amount) ?></td>
                        <td class="actions">
                            <?php echo $this->Html->link(
                                __('{0} Edit', '<i class="bi bi-check2-circle"></i>'),
                                '#modalBackoffice',
                                [
                                    'escape' => false,
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modalBackoffice',
                                    'data-remote' => $this->Url->build(['action' => 'addItem', $shoppingCart->partner->id, $shoppingCartItems->product->id]),
                                    'class' => __('btn btn-outline-{0} mt-auto', 'success'),
                                    'title' => __('Edit to cart')
                                ]
                            ); ?>
                            <?= $this->Form->postLink(__('{0} Delete', '<i class="bi bi-trash"></i>'), ['controller' => 'shoppingCartItems',  'action' => 'delete', $shoppingCartItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shoppingCart->id), 'title' => __('Delete'), 'class' => 'btn btn-danger', 'escape' => false]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('{0} Add more products', '<i class="bi bi-plus-circle"></i>'), ['action' => 'add', $shoppingCart->partner->id], ['escape' => false, 'class' => 'btn btn-secondary float-right']) ?>
</div>
