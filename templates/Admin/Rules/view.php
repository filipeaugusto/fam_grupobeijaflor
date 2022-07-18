<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rule $rule
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="rules view large-9 medium-8 columns content">
    <h3><?= h($rule->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($rule->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= h($rule->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($rule->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($rule->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <?php if (!empty($rule->users)): ?>
            <h4><?= __('Related Users') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Phone') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($rule->users as $users): ?>
                    <tr>
                        <td><?= h($users->name) ?></td>
                        <td><?= $this->Backoffice->phone($users->phone) ?></td>
                        <td><?= h($users->created) ?></td>
                        <td><?= h($users->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'Users', 'data' => $users]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
