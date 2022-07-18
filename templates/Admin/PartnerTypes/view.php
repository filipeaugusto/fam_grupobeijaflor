<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PartnerType $partnerType
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="partnerTypes view large-9 medium-8 columns content">
    <h3><?= h($partnerType->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($partnerType->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($partnerType->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Accept Orders') ?></th>
                <td><?= h($partnerType->accept_orders ? __('Yes') : __('No')) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($partnerType->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($partnerType->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <h4><?= __('Related Partners') ?></h4>
        <?php if (!empty($partnerType->partners)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Document') ?></th>
                    <th scope="col"><?= __('Image') ?></th>
                    <th scope="col"><?= __('Observations') ?></th>
                    <th scope="col"><?= __('Active') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($partnerType->partners as $partners): ?>
                <tr>
                    <td><?= $this->Backoffice->truncate($partners->id) ?></td>
                    <td><?= h($partners->name) ?></td>
                    <td><?= $this->Backoffice->document($partners->document) ?></td>
                    <td><?= h($partners->image) ?></td>
                    <td><?= h($partners->observations) ?></td>
                    <td><?= h($partners->active ? __('Yes') : __('No')) ?></td>
                    <td><?= h($partners->created) ?></td>
                    <td><?= h($partners->modified) ?></td>
                    <td class="actions">
                        <?php echo $this->element('table-actions', ['controller' => 'Partners', 'data' => $partners]); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
