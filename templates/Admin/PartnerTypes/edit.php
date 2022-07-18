<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PartnerType $partnerType
 * @var \App\Model\Entity\Partner[]|\Cake\Collection\CollectionInterface $partners
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="partnerTypes form content">
    <?= $this->Form->create($partnerType) ?>
    <fieldset>
        <legend><?= __('Edit Partner Type') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('accept_orders');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
