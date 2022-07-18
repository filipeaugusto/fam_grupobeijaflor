<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('rule_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= $this->Backoffice->truncate($user->id) ?></td>
                <td><?= $user->has('rule') ? $this->Html->link($user->rule->name, ['controller' => 'Rules', 'action' => 'view', $user->rule->id]) : '' ?></td>
                <td><?= h($user->name) ?></td>
                <td><?= $this->Backoffice->phone($user->phone) ?></td>
                <td><?= h($user->created) ?></td>
                <td><?= h($user->modified) ?></td>
                <td class="actions">
                    <?php echo $this->Form->postLink('<i class="bi bi-shield-lock-fill"></i>', ['action' => 'reset', $user->id], ['class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to reset the password # {0}?', $user->username), 'title' => __('reset password'), 'escape' => false]); ?>
                    <?php echo $this->element('Index/addresses', ['data' => $user]); ?>
                    <?php echo $this->element('table-actions', ['data' => $user]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
