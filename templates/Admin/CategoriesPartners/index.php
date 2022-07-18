<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesPartner[]|\Cake\Collection\CollectionInterface $categoriesPartners
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('partner_id') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($categoriesPartners as $categoriesPartner) : ?>
            <tr>
                <td><?= $categoriesPartner->has('category') ? $this->Html->link($categoriesPartner->category->name, ['controller' => 'Categories', 'action' => 'view', $categoriesPartner->category->id]) : '' ?></td>
                <td><?= $categoriesPartner->has('partner') ? $this->Html->link($categoriesPartner->partner->name, ['controller' => 'Partners', 'action' => 'view', $categoriesPartner->partner->id]) : '' ?></td>
                <td class="actions">
                    <?php echo $this->element('table-actions', ['data' => $categoriesPartner]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
