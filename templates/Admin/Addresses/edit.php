<?= $this->Form->create($address); ?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= __('{0} address', $address->isNew() ? 'Add' : 'Edit') ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <?php
    echo $this->Form->hidden('model');
    echo $this->Form->hidden('foreing_key');
    echo $this->Form->control('zip_code', ['class' => 'cep', 'type' => 'text', 'onblur' => 'pesquisacep(this.value);']);
    echo $this->Form->hidden('name');
    echo $this->Form->control('address', ['id' => 'rua']);
    echo $this->Form->control('number');
    echo $this->Form->control('complement');
    echo $this->Form->control('neighbourhood', ['id' => 'bairro']);
    echo $this->Form->control('city', ['id' => 'cidade']);
    echo $this->Form->control('state', ['id' => 'uf']);
    echo $this->Form->control('ibge', ['id' => 'ibge', 'readonly' => true]);
    echo $this->Form->hidden('type', ['default' => 'R']);
    ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= __('Close') ?></button>
    <button type="submit" class="btn btn-success"><?= __('Save changes') ?></button>
</div>
<?= $this->Form->end(); ?>
