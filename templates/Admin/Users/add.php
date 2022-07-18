<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\Rule[]|\Cake\Collection\CollectionInterface $rules
 * @var \App\Model\Entity\Company[]|\Cake\Collection\CollectionInterface $companies
 * @var \App\Model\Entity\OrderEvolution[]|\Cake\Collection\CollectionInterface $orderEvolutions
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 * @var \App\Model\Entity\ShoppingCart[]|\Cake\Collection\CollectionInterface $shoppingCarts
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="users form content">
    <?= $this->Form->create($user, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('rule_id', ['options' => $rules]);
//            echo $this->Form->control('company_id', ['options' => $companies]);
            echo $this->Form->control('name');
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            echo $this->Form->control('phone', ['class' => 'phone_with_ddd']);
            echo $this->Form->control('avatar', ['type' => 'file']);

            echo $this->Form->control('companies._ids', ['options' => $companies, 'multiple' => 'checkbox']);

        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
