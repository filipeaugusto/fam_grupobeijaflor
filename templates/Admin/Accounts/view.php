<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Account $account
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="accounts view large-9 medium-8 columns content">
    <h3><?= h($account->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= h($account->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Company') ?></th>
                <td><?= $account->has('company') ? $this->Html->link($account->company->name, ['controller' => 'Companies', 'action' => 'view', $account->company->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Agency') ?></th>
                <td><?= h($account->agency) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Account') ?></th>
                <td><?= h($account->account) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Bank') ?></th>
                <td><?= $this->Number->format($account->bank) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($account->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($account->modified) ?></td>
            </tr>
        </table>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
