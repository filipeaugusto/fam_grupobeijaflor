<?= $this->Form->create($billing) ?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= $billing->company->name ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <?php
            if ($billing->history_value > 0) {
                echo $this->Html->tag('h6', __('{0}: {1} - payment history {2}', $billing->description, $billing->deadline, $this->Backoffice->currency($billing->history_value)));
            } else {
                echo $this->Html->tag('h6', __('{0}: {1}', $billing->description, $billing->deadline));
            }
        ?>
        <?= $this->Form->control('value', ['required' => true, 'min' => '0.01', 'step' => '0.01']); ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Close') ?></button>
        <button type="submit" class="btn btn-success"><?= __('Save changes') ?></button>
    </div>
<?= $this->Form->end(); ?>
