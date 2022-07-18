<?= $this->Form->create($shoppingCartItem); ?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= __('{0} to cart', $shoppingCartItem->isNew() ? 'Add' : 'Edit') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <?php
            echo $this->Form->control('sale_price', ['min' => 1]);
            echo $this->Form->control('amount', ['min' => 1]);
        ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Close') ?></button>
        <button type="submit" class="btn btn-success"><?= __('Save changes') ?></button>
    </div>
<?= $this->Form->end(); ?>
