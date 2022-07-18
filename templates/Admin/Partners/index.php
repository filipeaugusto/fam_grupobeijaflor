<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Partner[]|\Cake\Collection\CollectionInterface $partners
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('partner_type_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('document') ?></th>
            <th scope="col"><?= $this->Paginator->sort('active') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions text-center" colspan="2"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($partners as $partner) : ?>
            <tr>
                <td><?= $this->Text->truncate($partner->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td><?= $partner->has('partner_type') ? $this->Html->link($partner->partner_type->name, ['controller' => 'PartnerTypes', 'action' => 'view', $partner->partner_type->id]) : '' ?></td>
                <td><?= h($partner->name) ?></td>
                <td><?= $this->Backoffice->document($partner->document) ?></td>
                <td><?= h($partner->active ? __('Yes') : __('No')) ?></td>
                <td><?= h($partner->created) ?></td>
                <td><?= h($partner->modified) ?></td>
                <td class="actions">
                    <?php echo $this->Html->link('<i class="bi bi-cash"></i>', '#modalBackoffice', ['data-toggle' => 'modal', 'data-target' => '#modalBackoffice', 'data-remote' => $this->Url->build(['controller' => 'partners', 'action' => 'money', $partner->id]), 'title' => __('Take out loan'), 'escape' => false, 'class' => __('btn {0}', ($partner->credit_line - $partner->open_credit_line > 0) ? 'btn-outline-success' : 'btn-secondary disabled') ]); ?>
                    <?php echo $this->Html->link('<i class="bi bi-basket"></i>', ['controller' => 'ShoppingCarts', 'action' => 'add', $partner->id], ['title' => __('Place order'), 'escape' => false, 'class' => __('btn {0}', $partner->partner_type->accept_orders ? 'btn-outline-info' : 'btn-secondary disabled') ]); ?>
                    <?php echo $this->element('Index/addresses', ['data' => $partner]); ?>
                    <?php echo $this->element('table-actions', ['data' => $partner]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
