<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShoppingCart $shoppingCart
 * @var \App\Model\Entity\Company[]|\Cake\Collection\CollectionInterface $companies
 * @var \App\Model\Entity\Partner[]|\Cake\Collection\CollectionInterface $partners
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 * @var \App\Model\Entity\Address[]|\Cake\Collection\CollectionInterface $addresses
 * @var \App\Model\Entity\ShoppingCartItem[]|\Cake\Collection\CollectionInterface $shoppingCartItems
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="shoppingCarts form content">
    <?= $this->Form->create($shoppingCart) ?>
    <fieldset>
        <legend><?= __('Edit Shopping Cart') ?></legend>
        <?php
            echo $this->Form->control('company_id', ['options' => $companies]);
            echo $this->Form->control('partner_id', ['options' => $partners]);
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('address_id', ['options' => $addresses, 'empty' => true]);
            echo $this->Form->control('delivery_date');
            echo $this->Form->control('observations');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
