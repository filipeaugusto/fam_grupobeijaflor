<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rule[]|\Cake\Collection\CollectionInterface $rules
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
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($rules as $rule) : ?>
            <tr>
                <td><?= h($rule->id) ?></td>
                <td><?= h($rule->name) ?></td>
                <td><?= h($rule->created) ?></td>
                <td><?= h($rule->modified) ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $rule]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
