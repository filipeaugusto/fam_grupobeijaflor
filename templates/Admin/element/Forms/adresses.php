<fieldset class="border p-2 mt-0 mb-5">
    <legend class="w-auto p-2"><?= __('Address information') ?></legend>
    <?php
        echo $this->Form->control('addresses.0.zip_code', ['class' => 'cep', 'type' => 'text', 'onblur' => 'pesquisacep(this.value);']);
        echo $this->Form->control('addresses.0.name');
        echo $this->Form->control('addresses.0.model', ['value' => $this->getRequest()->getParam('controller')]);
        echo $this->Form->control('addresses.0.address', ['id' => 'rua']);
        echo $this->Form->control('addresses.0.number');
        echo $this->Form->control('addresses.0.complement');
        echo $this->Form->control('addresses.0.neighbourhood', ['id' => 'bairro']);
        echo $this->Form->control('addresses.0.city', ['id' => 'cidade']);
        echo $this->Form->control('addresses.0.state', ['id' => 'uf']);
        echo $this->Form->control('addresses.0.ibge', ['id' => 'ibge', 'readonly' => true]);
        echo $this->Form->control('addresses.0.type', ['options' => ['R' => __('Residential'), 'C' => __('Commercial')]]);
    ?>
</fieldset>
