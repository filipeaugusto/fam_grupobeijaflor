<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategoriesPartner $categoriesPartner
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 * @var \App\Model\Entity\Partner[]|\Cake\Collection\CollectionInterface $partners
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="categoriesPartners form content">
    <?= $this->Form->create($categoriesPartner) ?>
    <fieldset>
        <legend><?= __('Edit Categories Partner') ?></legend>
        <?php
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
