<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderEvolution $orderEvolution
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 * @var \App\Model\Entity\OrderStatus[]|\Cake\Collection\CollectionInterface $orderStatus
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="orderEvolutions form content">
    <?= $this->Form->create($orderEvolution) ?>
    <fieldset>
        <legend><?= __('Add Order Evolution') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('order_id', ['options' => $orders]);
            echo $this->Form->control('order_status_id', ['options' => $orderStatus]);
            echo $this->Form->control('date_start');
            echo $this->Form->control('date_end', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
