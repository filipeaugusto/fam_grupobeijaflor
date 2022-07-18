<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Attachment $attachment
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="attachments view large-9 medium-8 columns content">
    <h3><?= $this->Backoffice->truncate($attachment->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($attachment->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Model') ?></th>
                <td><?= h($attachment->model) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Foreing Key') ?></th>
                <td><?= h($attachment->foreing_key) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Archive') ?></th>
                <td><?= $this->Backoffice->archive($attachment->archive, ['alt' => $attachment->model, 'title' => $attachment->model, 'width' => '100px']) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($attachment->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($attachment->modified) ?></td>
            </tr>
        </table>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
