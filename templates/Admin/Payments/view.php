<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="payments view large-9 medium-8 columns content">
    <h3><?= h($payment->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= h($payment->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($payment->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Observations') ?></th>
                <td><?= h($payment->observations) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Repeat Value') ?></th>
                <td><?= h($payment->repeat_value ? __('Yes') : __('No')) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Frequency') ?></th>
                <td><?= h($payment->frequency) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Type') ?></th>
                <td><?= __($payment->type) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Value') ?></th>
                <td><?= $this->Number->format($payment->value) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Pay When') ?></th>
                <td><?= $this->Number->format($payment->pay_when) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($payment->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($payment->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <h4><?= __('Related Companies') ?></h4>
        <?php if (!empty($payment->companies)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Document') ?></th>
                    <th scope="col"><?= __('Phone') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($payment->companies as $companies): ?>
                <tr>
                    <td><?= h($companies->name) ?></td>
                    <td><?= $this->Backoffice->document($companies->document) ?></td>
                    <td><?= $this->Backoffice->phone($companies->phone) ?></td>
                    <td><?= h($companies->created) ?></td>
                    <td><?= h($companies->modified) ?></td>
                    <td class="actions">
                        <?php echo $this->element('table-actions', ['controller' => 'Companies', 'data' => $companies]); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
