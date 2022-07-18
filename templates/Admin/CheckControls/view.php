<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CheckControl $checkControl
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="checkControls view large-9 medium-8 columns content">
    <h3><?= $this->Backoffice->truncate($checkControl->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($checkControl->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Company') ?></th>
                <td><?= $checkControl->has('company') ? $this->Html->link($checkControl->company->name, ['controller' => 'Companies', 'action' => 'view', $checkControl->company->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('File Import') ?></th>
                <td><?= $checkControl->has('file_import') ? $this->Html->link($checkControl->file_import->id, ['controller' => 'FileImports', 'action' => 'view', $checkControl->file_import->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Partner') ?></th>
                <td><?= $checkControl->has('partner') ? $this->Html->link($checkControl->partner->name, ['controller' => 'Partners', 'action' => 'view', $checkControl->partner->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Document') ?></th>
                <td><?= $this->Backoffice->document($checkControl->document) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Bank') ?></th>
                <td><?= h($checkControl->bank) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Agency') ?></th>
                <td><?= h($checkControl->agency) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Account') ?></th>
                <td><?= h($checkControl->account) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Number') ?></th>
                <td><?= h($checkControl->number) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Confirmation User Id') ?></th>
                <td><?= $this->Backoffice->truncate($checkControl->confirmation_user_id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('User') ?></th>
                <td><?= $checkControl->has('user') ? $this->Html->link($checkControl->user->name, ['controller' => 'Users', 'action' => 'view', $checkControl->user->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Value') ?></th>
                <td><?= $this->Backoffice->currency($checkControl->value) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Deadline') ?></th>
                <td><?= h($checkControl->deadline) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Confirmation') ?></th>
                <td><?= $checkControl->confirmation ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Confirmation Date') ?></th>
                <td><?= h($checkControl->confirmation_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Destination') ?></th>
                <td><?= $checkControl->destination ? __('Yes') : __('No'); ?></td>
            </tr>            <tr>
                <th scope="row"><?= __('Destination Date') ?></th>
                <td><?= h($checkControl->destination_date) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Description') ?></th>
                <td><?= h($checkControl->description) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($checkControl->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($checkControl->modified) ?></td>
            </tr>
        </table>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
