<?= $this->Form->create($billingSlip) ?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= $billingSlip->company->name ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <h6><?= __('{0}: {1}', $billingSlip->description, $billingSlip->deadline) ?></h6>
        <?= $this->Form->control('account_id', ['options' => $accounts, 'empty' => true, 'required' => true, 'label' => __('Accounts')]); ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Close') ?></button>
        <button type="submit" class="btn btn-success"><?= __('Save changes') ?></button>
    </div>
<?= $this->Form->end(); ?>
