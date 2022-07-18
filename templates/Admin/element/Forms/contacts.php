<fieldset class="border p-2 mt-0 mb-5">
    <legend class="w-auto p-2"><?= __('Contact information') ?></legend>
    <?php
        echo $this->Form->control('contacts.0.id');
        echo $this->Form->control('contacts.0.name');
        echo $this->Form->control('contacts.0.email');
        echo $this->Form->control('contacts.0.phone', ['class' => 'phone_with_ddd']);
        echo $this->Form->control('contacts.0.observations');
    ?>
</fieldset>
