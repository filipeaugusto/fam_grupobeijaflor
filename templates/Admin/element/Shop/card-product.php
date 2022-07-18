<div class="card m-2 <?= $existing ? 'border-success' : ''; ?>" style="width: 18rem;">
    <?= $this->Backoffice->archive($product->image, ['folder' => 'products', 'alt' => $product->name, 'title' => $product->name, 'class' => 'card-img-top']) ?>
    <div class="card-body bg-white">
        <div class="text-center">
            <!-- Product name-->
            <h5 class="fw-bolder"><?= h($product->name); ?></h5>
            <!-- Product price-->
            <span class="text-muted" title="<?= __('Price history') ?>"><?= $this->Backoffice->currency($product->history_price); ?></span>
        </div>
    </div>
    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
        <div class="text-center">
            <?php echo $this->Html->link(
                ($existing ? __('{0} Edit to cart', '<i class="bi bi-check2-circle"></i>') : __('{0} Add to cart', '<i class="bi bi-plus-circle"></i>')),
                '#modalBackoffice',
                [
                    'escape' => false,
                    'data-toggle' => 'modal',
                    'data-target' => '#modalBackoffice',
                    'data-remote' => $this->Url->build(['action' => 'addItem', $this->request->getParam('pass')[0], $product->id]),
                    'class' => __('btn btn-outline-{0} mt-auto', $existing ? 'success' : 'secondary'),
                    'title' => $existing ? __('Edit to cart') : __('Add to cart')
                ]
            ); ?>
        </div>
    </div>
</div>
