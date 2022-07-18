<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="categories view large-9 medium-8 columns content">
    <h3><?= h($category->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($category->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Parent Id') ?></th>
                <td><?= $this->Backoffice->truncate($category->parent_id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($category->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Image') ?></th>
                <td><?= $this->Backoffice->archive($category->image, ['alt' => $category->name, 'title' => $category->name, 'width' => '100px']) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($category->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($category->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <?php if (!empty($category->partners)): ?>
            <h4><?= __('Related Partners') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Document') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($category->partners as $partners): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($partners->id) ?></td>
                        <td><?= h($partners->name) ?></td>
                        <td><?= $this->Backoffice->document($partners->document) ?></td>
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
    <div class="related">
        <?php if (!empty($category->child_categories)): ?>
            <h4><?= __('Related Categories') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Image') ?></th>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($category->child_categories as $categories): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($categories->id) ?></td>
                        <td><?= $this->Backoffice->archive($categories->image, ['alt' => $categories->name, 'title' => $categories->name, 'width' => '100px']) ?></td>
                        <td><?= h($categories->name) ?></td>
                        <td><?= h($categories->created) ?></td>
                        <td><?= h($categories->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'Categories', 'data' => $categories]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($category->products)): ?>
            <h4><?= __('Related Products') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Code') ?></th>
                        <th scope="col"><?= __('Store Stock') ?></th>
                        <th scope="col"><?= __('Reserve Stock') ?></th>
                        <th scope="col"><?= __('History Price') ?></th>
                        <th scope="col"><?= __('Validate Stock') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($category->products as $products): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($products->id) ?></td>
                        <td><?= h($products->name) ?></td>
                        <td><?= h($products->code) ?></td>
                        <td><?= h($products->store_stock) ?></td>
                        <td><?= h($products->reserve_stock) ?></td>
                        <td><?= h($products->history_price) ?></td>
                        <td><?= h($products->validate_stock ? __('Yes') : __('No')) ?></td>
                        <td><?= h($products->created) ?></td>
                        <td><?= h($products->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'Products', 'data' => $products]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
