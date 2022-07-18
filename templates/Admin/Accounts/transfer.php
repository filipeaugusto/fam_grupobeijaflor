<?php

use Cake\I18n\FrozenTime;

?>
<?= $this->Form->create($account) ?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Realizar transferência</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <h6>De: <?= $account->details ?></h6>
        <?= $this->Form->control('account_id', ['required' => true, 'label' => 'Para:']); ?>
        <?= $this->Form->control('deadline', ['required' => true, 'type' => 'date', 'label' => 'Data da transferência', 'default' => FrozenTime::now()]); ?>
        <?= $this->Form->control('observations', ['required' => true, 'type' => 'textarea', 'rows' => 3]); ?>
        <?= $this->Form->control('value', ['type' => 'number', 'required' => true, 'min' => '0.01', 'step' => '0.01']); ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Close') ?></button>
        <button type="submit" class="btn btn-success"><?= __('Save changes') ?></button>
    </div>
<?= $this->Form->end(); ?>
