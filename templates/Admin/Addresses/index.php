<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Address[]|\Cake\Collection\CollectionInterface $addresses
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>
<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('model') ?></th>
            <th scope="col"><?= $this->Paginator->sort('zip_code') ?></th>
            <th scope="col"><?= $this->Paginator->sort('city') ?></th>
            <th scope="col"><?= $this->Paginator->sort('state') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($addresses as $address) : ?>
            <tr>
                <td><?= $this->Backoffice->truncate($address->id) ?></td>
                <td><?= h($address->model) ?></td>
                <td><?= $this->Backoffice->zipcode($address->zip_code) ?></td>
                <td><?= h($address->city) ?></td>
                <td><?= h($address->state) ?></td>
                <td><?= h($address->created) ?></td>
                <td><?= h($address->modified) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
