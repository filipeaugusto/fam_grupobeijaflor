<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Partner $partner
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="partners view large-9 medium-8 columns content">
    <h3><?= h($partner->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($partner->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Partner Type') ?></th>
                <td><?= $partner->has('partner_type') ? $this->Html->link($partner->partner_type->name, ['controller' => 'PartnerTypes', 'action' => 'view', $partner->partner_type->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($partner->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Categoria de transação principal') ?></th>
                <td><?= $partner->has('expense_category') ? $this->Html->link($partner->partner_type->name, ['controller' => 'ExpenseCategories', 'action' => 'view', $partner->expense_category->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Document') ?></th>
                <td><?= $this->Backoffice->document($partner->document) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Credit Line') ?></th>
                <td>
                    <?= $this->Backoffice->currency($partner->credit_line) ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Value In Use') ?></th>
                <td class="text-danger"><?= $this->Backoffice->currency($partner->open_credit_line) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Open Credit Line') ?></th>
                <td class="text-success"><?= $this->Backoffice->currency($partner->credit_line - $partner->open_credit_line) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Image') ?></th>
                <td><?= $this->Backoffice->archive($partner->image, ['alt' => $partner->name, 'title' => $partner->name, 'width' => '100px']) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Active') ?></th>
                <td><?= $partner->active ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Observations') ?></th>
                <td><?= h($partner->observations) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($partner->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($partner->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <?php if (!empty($partner->categories)): ?>
            <h4><?= __('Related Categories') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Image') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($partner->categories as $categories): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($categories->id) ?></td>
                        <td><?= h($categories->name) ?></td>
                        <td><?= h($categories->image) ?></td>
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
        <?php if (!empty($partner->check_controls)): ?>
            <h4><?= __('Related Check Controls') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Company Id') ?></th>
                        <th scope="col"><?= __('File Import Id') ?></th>
                        <th scope="col"><?= __('Document') ?></th>
                        <th scope="col"><?= __('Bank') ?></th>
                        <th scope="col"><?= __('Agency') ?></th>
                        <th scope="col"><?= __('Account') ?></th>
                        <th scope="col"><?= __('Number') ?></th>
                        <th scope="col"><?= __('Value') ?></th>
                        <th scope="col"><?= __('Deadline') ?></th>
                        <th scope="col"><?= __('Description') ?></th>
                        <th scope="col"><?= __('Confirmation') ?></th>
                        <th scope="col"><?= __('Confirmation User Id') ?></th>
                        <th scope="col"><?= __('Confirmation Date') ?></th>
                        <th scope="col"><?= __('Destination') ?></th>
                        <th scope="col"><?= __('Destination User Id') ?></th>
                        <th scope="col"><?= __('Destination Date') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($partner->check_controls as $checkControls): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($checkControls->id) ?></td>
                        <td><?= $this->Backoffice->truncate($checkControls->company_id) ?></td>
                        <td><?= $this->Backoffice->truncate($checkControls->file_import_id) ?></td>
                        <td><?= $this->Backoffice->document($checkControls->document) ?></td>
                        <td><?= h($checkControls->bank) ?></td>
                        <td><?= h($checkControls->agency) ?></td>
                        <td><?= h($checkControls->account) ?></td>
                        <td><?= h($checkControls->number) ?></td>
                        <td><?= h($checkControls->value) ?></td>
                        <td><?= h($checkControls->deadline) ?></td>
                        <td><?= h($checkControls->description) ?></td>
                        <td><?= h($checkControls->confirmation) ?></td>
                        <td><?= $this->Backoffice->truncate($checkControls->confirmation_user_id) ?></td>
                        <td><?= h($checkControls->confirmation_date) ?></td>
                        <td><?= h($checkControls->destination) ?></td>
                        <td><?= $this->Backoffice->truncate($checkControls->destination_user_id) ?></td>
                        <td><?= h($checkControls->destination_date) ?></td>
                        <td><?= h($checkControls->created) ?></td>
                        <td><?= h($checkControls->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'CheckControls', 'data' => $checkControls]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($partner->contacts)): ?>
            <h4><?= __('Related Contacts') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Email') ?></th>
                        <th scope="col"><?= __('Phone') ?></th>
                        <th scope="col"><?= __('Observations') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($partner->contacts as $contacts): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($contacts->id) ?></td>
                        <td><?= h($contacts->name) ?></td>
                        <td><?= h($contacts->email) ?></td>
                        <td><?= $this->Backoffice->phone($contacts->phone) ?></td>
                        <td><?= h($contacts->observations) ?></td>
                        <td><?= h($contacts->created) ?></td>
                        <td><?= h($contacts->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'Contacts', 'data' => $contacts]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($partner->orders)): ?>
            <h4><?= __('Related Orders') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Company Id') ?></th>
                        <th scope="col"><?= __('User Id') ?></th>
                        <th scope="col"><?= __('Order Status Id') ?></th>
                        <th scope="col"><?= __('Address Id') ?></th>
                        <th scope="col"><?= __('Billing Id') ?></th>
                        <th scope="col"><?= __('Delivery Date') ?></th>
                        <th scope="col"><?= __('Observations') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($partner->orders as $orders): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($orders->id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->company_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->user_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->order_status_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->address_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->billing_id) ?></td>
                        <td><?= h($orders->delivery_date) ?></td>
                        <td><?= h($orders->observations) ?></td>
                        <td><?= h($orders->created) ?></td>
                        <td><?= h($orders->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'Orders', 'data' => $orders]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($partner->shopping_carts)): ?>
            <h4><?= __('Related Shopping Carts') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Company Id') ?></th>
                        <th scope="col"><?= __('Partner Id') ?></th>
                        <th scope="col"><?= __('User Id') ?></th>
                        <th scope="col"><?= __('Address Id') ?></th>
                        <th scope="col"><?= __('Delivery Date') ?></th>
                        <th scope="col"><?= __('Observations') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($partner->shopping_carts as $shoppingCarts): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($shoppingCarts->id) ?></td>
                        <td><?= $this->Backoffice->truncate($shoppingCarts->company_id) ?></td>
                        <td><?= $this->Backoffice->truncate($shoppingCarts->partner_id) ?></td>
                        <td><?= $this->Backoffice->truncate($shoppingCarts->user_id) ?></td>
                        <td><?= $this->Backoffice->truncate($shoppingCarts->address_id) ?></td>
                        <td><?= h($shoppingCarts->delivery_date) ?></td>
                        <td><?= h($shoppingCarts->observations) ?></td>
                        <td><?= h($shoppingCarts->created) ?></td>
                        <td><?= h($shoppingCarts->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'ShoppingCarts', 'data' => $shoppingCarts]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
