<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact[]|\Cake\Collection\CollectionInterface $contacts
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('partner_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('email') ?></th>
            <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact) : ?>
            <tr>
                <td><?= $this->Text->truncate($contact->id, 8, ['ellipsis' => '', 'exact' => true]) ?></td>
                <td><?= $contact->has('partner') ? $this->Html->link($contact->partner->name, ['controller' => 'Partners', 'action' => 'view', $contact->partner->id]) : '' ?></td>
                <td><?= h($contact->name) ?></td>
                <td><?= h($contact->email) ?></td>
                <td><?= $this->Backoffice->phone($contact->phone) ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $contact]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
