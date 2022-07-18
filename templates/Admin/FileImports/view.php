<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FileImport $fileImport
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="fileImports view large-9 medium-8 columns content">
    <h3><?= $this->Backoffice->truncate($fileImport->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($fileImport->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Company') ?></th>
                <td><?= $fileImport->has('company') ? $this->Html->link($fileImport->company->name, ['controller' => 'Companies', 'action' => 'view', $fileImport->company->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Archive') ?></th>
                <td><?= $this->Backoffice->archive($fileImport->archive) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($fileImport->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($fileImport->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Finished') ?></th>
                <td><?= $fileImport->finished ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <h4><?= __('Related Check Controls') ?></h4>
        <?php if (!empty($fileImport->check_controls)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Company Id') ?></th>
                    <th scope="col"><?= __('Document') ?></th>
                    <th scope="col"><?= __('Bank') ?></th>
                    <th scope="col"><?= __('Agency') ?></th>
                    <th scope="col"><?= __('Account') ?></th>
                    <th scope="col"><?= __('Number') ?></th>
                    <th scope="col"><?= __('Value') ?></th>
                    <th scope="col"><?= __('Deadline') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($fileImport->check_controls as $checkControls): ?>
                <tr>
                    <td><?= $this->Backoffice->truncate($checkControls->id) ?></td>
                    <td><?= $this->Backoffice->truncate($checkControls->company_id) ?></td>
                    <td><?= $this->Backoffice->document($checkControls->document) ?></td>
                    <td><?= h($checkControls->bank) ?></td>
                    <td><?= h($checkControls->agency) ?></td>
                    <td><?= h($checkControls->account) ?></td>
                    <td><?= h($checkControls->number) ?></td>
                    <td><?= h($checkControls->value) ?></td>
                    <td><?= h($checkControls->deadline) ?></td>
                    <td><?= h($checkControls->created) ?></td>
                    <td><?= h($checkControls->modified) ?></td>
                    <td class="actions">
                        <?php echo $this->element('table-actions', ['controller' => 'CheckControls', 'data' => $checkControls]); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
