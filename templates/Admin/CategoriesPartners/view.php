<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesPartner $categoriesPartner
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="categoriesPartners view large-9 medium-8 columns content">
    <h3><?= $this->Backoffice->truncate($categoriesPartner->category_id) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Category') ?></th>
                <td><?= $categoriesPartner->has('category') ? $this->Html->link($categoriesPartner->category->name, ['controller' => 'Categories', 'action' => 'view', $categoriesPartner->category->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Partner') ?></th>
                <td><?= $categoriesPartner->has('partner') ? $this->Html->link($categoriesPartner->partner->name, ['controller' => 'Partners', 'action' => 'view', $categoriesPartner->partner->id]) : '' ?></td>
            </tr>
        </table>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
