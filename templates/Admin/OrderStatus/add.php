<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderStatus $orderStatus
 * @var \App\Model\Entity\ParentOrderStatus[]|\Cake\Collection\CollectionInterface $parentOrderStatus
 * @var \App\Model\Entity\OrderEvolution[]|\Cake\Collection\CollectionInterface $orderEvolutions
 * @var \App\Model\Entity\ChildOrderStatus[]|\Cake\Collection\CollectionInterface $childOrderStatus
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="orderStatus form content">
    <?= $this->Form->create($orderStatus) ?>
    <fieldset>
        <legend><?= __('Add Order Status') ?></legend>
        <?php
            echo $this->Form->control('parent_id', ['options' => $parentOrderStatus, 'empty' => true]);
            echo $this->Form->control('name');
            echo $this->Form->control('background_color', ['type' => 'color']);
            echo $this->Form->control('font_color', ['type' => 'color']);
            echo $this->Form->control('active');
            echo $this->Form->control('type', ['options' => ['process' => __('Process'), 'cancel' => __('Cancel')]]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
