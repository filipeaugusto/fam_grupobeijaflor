<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 * @var \App\Model\Entity\Company[]|\Cake\Collection\CollectionInterface $companies
 * @var \App\Model\Entity\Partner[]|\Cake\Collection\CollectionInterface $partners
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 * @var \App\Model\Entity\OrderStatus[]|\Cake\Collection\CollectionInterface $orderStatus
 * @var \App\Model\Entity\Address[]|\Cake\Collection\CollectionInterface $addresses
 * @var \App\Model\Entity\Billing[]|\Cake\Collection\CollectionInterface $billings
 * @var \App\Model\Entity\OrderEvolution[]|\Cake\Collection\CollectionInterface $orderEvolutions
 * @var \App\Model\Entity\OrderProduct[]|\Cake\Collection\CollectionInterface $orderProducts
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="orders form content">
    <?= $this->Form->create($order, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Edit Order') ?></legend>
        <?php
//            echo $this->Form->control('company_id', ['options' => $companies]);
//            echo $this->Form->control('partner_id', ['options' => $partners]);
//            echo $this->Form->control('user_id', ['options' => $users]);
//            echo $this->Form->control('order_status_id', ['options' => $orderStatus]);
//            echo $this->Form->control('address_id', ['options' => $addresses, 'empty' => true]);
//            echo $this->Form->control('billing_id', ['options' => $billings, 'empty' => true]);
            echo $this->Form->control('delivery_date');
            echo $this->Form->control('observations');
            echo $this->Form->control('archive', ['type' => 'file']);
            echo $this->Form->hidden('order_status_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
