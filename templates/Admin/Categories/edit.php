<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 * @var \App\Model\Entity\Partner[]|\Cake\Collection\CollectionInterface $partners
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="categories form content">
    <?= $this->Form->create($category, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Edit Category') ?></legend>
        <?php
            echo $this->Form->control('parent_id', ['options' => $parentCategories, 'empty' => true]);
            echo $this->Form->control('name');
            echo $this->Form->control('image', ['type' => 'file']);
            echo $this->Form->control('partners._ids', ['options' => $partners, 'multiple' => 'checkbox']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
