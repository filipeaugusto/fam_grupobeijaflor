<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="companies view large-9 medium-8 columns content">
    <h3><?= h($company->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($company->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Parent Company') ?></th>
                <td><?= $company->has('parent_company') ? $this->Html->link($company->parent_company->name, ['controller' => 'Companies', 'action' => 'view', $company->parent_company->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($company->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Document') ?></th>
                <td><?= $this->Backoffice->document($company->document) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Logo') ?></th>
                <td><?= $this->Backoffice->archive($company->logo, ['alt' => $company->name, 'title' => $company->name, 'width' => '100px']) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Phone') ?></th>
                <td><?= $this->Backoffice->phone($company->phone) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Information') ?></th>
                <td><?= h($company->information) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($company->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($company->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <?php if (!empty($company->billings)): ?>
            <h4><?= __('Related Billings') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Company Id') ?></th>
                        <th scope="col"><?= __('Model') ?></th>
                        <th scope="col"><?= __('Foreing Key') ?></th>
                        <th scope="col"><?= __('Deadline') ?></th>
                        <th scope="col"><?= __('Description') ?></th>
                        <th scope="col"><?= __('Value') ?></th>
                        <th scope="col"><?= __('Type') ?></th>
                        <th scope="col"><?= __('Confirmation') ?></th>
                        <th scope="col"><?= __('Confirmation User Id') ?></th>
                        <th scope="col"><?= __('Confirmation Date') ?></th>
                        <th scope="col"><?= __('Removed') ?></th>
                        <th scope="col"><?= __('Removed User Id') ?></th>
                        <th scope="col"><?= __('Removed Date') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($company->billings as $billings): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($billings->id) ?></td>
                        <td><?= $this->Backoffice->truncate($billings->company_id) ?></td>
                        <td><?= h($billings->model) ?></td>
                        <td><?= h($billings->foreing_key) ?></td>
                        <td><?= h($billings->deadline) ?></td>
                        <td><?= h($billings->description) ?></td>
                        <td><?= h($billings->value) ?></td>
                        <td><?= h($billings->type) ?></td>
                        <td><?= h($billings->confirmation) ?></td>
                        <td><?= $this->Backoffice->truncate($billings->confirmation_user_id) ?></td>
                        <td><?= h($billings->confirmation_date) ?></td>
                        <td><?= h($billings->removed) ?></td>
                        <td><?= $this->Backoffice->truncate($billings->removed_user_id) ?></td>
                        <td><?= h($billings->removed_date) ?></td>
                        <td><?= h($billings->created) ?></td>
                        <td><?= h($billings->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'Billings', 'data' => $billings]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($company->check_controls)): ?>
            <h4><?= __('Related Check Controls') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Company Id') ?></th>
                        <th scope="col"><?= __('File Import Id') ?></th>
                        <th scope="col"><?= __('Partner Id') ?></th>
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
                    <?php foreach ($company->check_controls as $checkControls): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($checkControls->id) ?></td>
                        <td><?= $this->Backoffice->truncate($checkControls->company_id) ?></td>
                        <td><?= $this->Backoffice->truncate($checkControls->file_import_id) ?></td>
                        <td><?= $this->Backoffice->truncate($checkControls->partner_id) ?></td>
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
        <?php if (!empty($company->child_companies)): ?>
            <h4><?= __('Related Companies') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Parent Id') ?></th>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Document') ?></th>
                        <th scope="col"><?= __('Logo') ?></th>
                        <th scope="col"><?= __('Phone') ?></th>
                        <th scope="col"><?= __('Information') ?></th>
                        <th scope="col"><?= __('Lft') ?></th>
                        <th scope="col"><?= __('Rght') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($company->child_companies as $childCompanies): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($childCompanies->id) ?></td>
                        <td><?= $this->Backoffice->truncate($childCompanies->parent_id) ?></td>
                        <td><?= h($childCompanies->name) ?></td>
                        <td><?= $this->Backoffice->document($childCompanies->document) ?></td>
                        <td><?= h($childCompanies->logo) ?></td>
                        <td><?= $this->Backoffice->phone($childCompanies->phone) ?></td>
                        <td><?= h($childCompanies->information) ?></td>
                        <td><?= h($childCompanies->lft) ?></td>
                        <td><?= h($childCompanies->rght) ?></td>
                        <td><?= h($childCompanies->created) ?></td>
                        <td><?= h($childCompanies->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'Companies', 'data' => $childCompanies]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($company->file_imports)): ?>
            <h4><?= __('Related File Imports') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Company Id') ?></th>
                        <th scope="col"><?= __('Archive') ?></th>
                        <th scope="col"><?= __('Finished') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($company->file_imports as $fileImports): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($fileImports->id) ?></td>
                        <td><?= $this->Backoffice->truncate($fileImports->company_id) ?></td>
                        <td><?= h($fileImports->archive) ?></td>
                        <td><?= h($fileImports->finished) ?></td>
                        <td><?= h($fileImports->created) ?></td>
                        <td><?= h($fileImports->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'FileImports', 'data' => $fileImports]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($company->orders)): ?>
            <h4><?= __('Related Orders') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Company Id') ?></th>
                        <th scope="col"><?= __('Partner Id') ?></th>
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
                    <?php foreach ($company->orders as $orders): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($orders->id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->company_id) ?></td>
                        <td><?= $this->Backoffice->truncate($orders->partner_id) ?></td>
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
        <?php if (!empty($company->payments)): ?>
            <h4><?= __('Related Payments') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Company Id') ?></th>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Value') ?></th>
                        <th scope="col"><?= __('Pay When') ?></th>
                        <th scope="col"><?= __('frequency') ?></th>
                        <th scope="col"><?= __('Type') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($company->payments as $payments): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($payments->id) ?></td>
                        <td><?= $this->Backoffice->truncate($payments->company_id) ?></td>
                        <td><?= h($payments->name) ?></td>
                        <td><?= h($payments->value) ?></td>
                        <td><?= h($payments->pay_when) ?></td>
                        <td><?= h($payments->frequency) ?></td>
                        <td><?= h($payments->type) ?></td>
                        <td><?= h($payments->created) ?></td>
                        <td><?= h($payments->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'Payments', 'data' => $payments]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <?php if (!empty($company->shopping_carts)): ?>
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
                    <?php foreach ($company->shopping_carts as $shoppingCarts): ?>
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
    <div class="related">
        <?php if (!empty($company->users)): ?>
            <h4><?= __('Related Users') ?></h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Rule Id') ?></th>
                        <th scope="col"><?= __('Company Id') ?></th>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Username') ?></th>
                        <th scope="col"><?= __('Password') ?></th>
                        <th scope="col"><?= __('Phone') ?></th>
                        <th scope="col"><?= __('Avatar') ?></th>
                        <th scope="col"><?= __('Token') ?></th>
                        <th scope="col"><?= __('Token Validity') ?></th>
                        <th scope="col"><?= __('Api Key') ?></th>
                        <th scope="col"><?= __('Api Key Plain') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($company->users as $users): ?>
                    <tr>
                        <td><?= $this->Backoffice->truncate($users->id) ?></td>
                        <td><?= $this->Backoffice->truncate($users->rule_id) ?></td>
                        <td><?= $this->Backoffice->truncate($users->company_id) ?></td>
                        <td><?= h($users->name) ?></td>
                        <td><?= h($users->username) ?></td>
                        <td><?= h($users->password) ?></td>
                        <td><?= $this->Backoffice->phone($users->phone) ?></td>
                        <td><?= h($users->avatar) ?></td>
                        <td><?= h($users->token) ?></td>
                        <td><?= h($users->token_validity) ?></td>
                        <td><?= h($users->api_key) ?></td>
                        <td><?= h($users->api_key_plain) ?></td>
                        <td><?= h($users->created) ?></td>
                        <td><?= h($users->modified) ?></td>
                        <td class="actions">
                            <?php echo $this->element('table-actions', ['controller' => 'Users', 'data' => $users]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
