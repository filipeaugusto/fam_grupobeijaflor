<?= $this->Form->create($partner); ?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Realizar empréstimo: <?= $partner->name ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <span></span>
    <?php
    echo $this->Form->control('company_id', ['options' => $companies]);
    echo $this->Form->control('credit_line', ['label' => __('Linha de crédito - limite: {0}', $this->Backoffice->currency($partner->credit_line - $partner->open_credit_line)), 'value' => $partner->credit_line - $partner->open_credit_line, 'min' => 1, 'max' => ($partner->credit_line - $partner->open_credit_line)]);
    echo $this->Form->control('break', ['options' => array_merge([0 => 1], range(3, 12, 3))]);
    ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Close') ?></button>
    <button type="submit" class="btn btn-success"><?= __('Save changes') ?></button>
</div>
<?= $this->Form->end(); ?>

