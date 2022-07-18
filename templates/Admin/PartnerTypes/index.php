<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PartnerType[]|\Cake\Collection\CollectionInterface $partnerTypes
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('accept_orders') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($partnerTypes as $partnerType) : ?>
            <tr>
                <td><?= $this->Text->truncate($partnerType->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td><?= h($partnerType->name) ?></td>
                <td><?= h($partnerType->accept_orders ? __('Yes') : __('No')) ?></td>
                <td><?= h($partnerType->created) ?></td>
                <td><?= h($partnerType->modified) ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $partnerType]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
