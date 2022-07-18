<?php
    $this->extend('/layout/TwitterBootstrap/dashboard');

    echo $this->element('menu-actions');

?>

<?php if (count($missedPayments) > 0) { ?>
    <div class="row">
        <div class="col-md-12">
            <h2><?= __('Payments awaiting confirmation') ?></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Status') ?></th>
                        <th scope="col"><?= __('Company') ?></th>
                        <th scope="col"><?= __('Information') ?></th>
                        <th scope="col"><?= __('Deadline') ?></th>
                        <th scope="col"><?= __('Value') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($missedPayments as $missedPayment) : ?>
                    <tr id="<?= h($missedPayment->id) ?>" title="<?= h($missedPayment->description) ?>">
                        <td>
                            <?= $this->Html->tag('i', null, ['class' => $missedPayment->status_emoji]) ?>
                            - 
                            <?= __(ucfirst($missedPayment->type)) ?>
                        </td>
                        <td>
                            <?= $missedPayment->has('company') ? $this->Html->link($missedPayment->company->name, ['controller' => 'Companies', 'action' => 'view', $missedPayment->company->id]) : '' ?>
                        </td>
                        <td><?= h($missedPayment->description) ?></td>
                        <td><?= h($missedPayment->deadline) ?></td>
                        <td><?= $this->Backoffice->currency($missedPayment->value) ?></td>
                        <td><?= h($missedPayment->created) ?></td>
                        <td><?= h($missedPayment->modified) ?></td>
                        <td class="actions">
                            <?php
                            echo $this->Html->link('<i class="bi bi-arrow-repeat"></i>',
                                '#modalBackoffice',
                                [
                                    'escape' => false,
                                    'class' => 'btn btn-outline-secondary',
                                    'title' => __('Waiting'),
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modalBackoffice',
                                    'data-remote' => $this->Url->build(['controller' => 'billings', 'action' => 'waiting', $missedPayment->id]),
                                ]
                            );
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-6">
        <fieldset class="border p-2 mt-0 mb-5">
            <legend class="w-auto p-2"><?= __('Monthly inputs and outputs') ?></legend>
            <?php echo $this->element('Dashboard/billings', ['data' => $billing_monthly]); ?>
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset class="border p-2 mt-0 mb-5">
            <legend class="w-auto p-2"><?= __('Yearly inputs and outputs') ?></legend>
            <?php echo $this->element('Dashboard/billings', ['data' => $billing_yearly]); ?>
        </fieldset>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <fieldset class="border p-2 mt-0 mb-5">
            <legend class="w-auto p-2"><?= __('Processing of monthly checks') ?></legend>
            <?php echo $this->element('Dashboard/billings', ['data' => $check_monthly]); ?>
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset class="border p-2 mt-0 mb-5">
            <legend class="w-auto p-2"><?= __('Processing of annual checks') ?></legend>
            <?php echo $this->element('Dashboard/billings', ['data' => $check_yearly]); ?>
        </fieldset>
    </div>
</div>


<!--<div class="row">-->
<!--    <div class="col-sm-6">-->
<!--        <div class="card text-white bg-primary mb-3">-->
<!--            <div class="card-header">Header</div>-->
<!--            <div class="card-body">-->
<!--                <h5 class="card-title">Primary card title</h5>-->
<!--                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
<!--            </div>-->
<!--            <div class="card-footer">Footer</div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-sm-6">-->
<!--        <div class="card text-white bg-secondary mb-3">-->
<!--            <div class="card-header">Header</div>-->
<!--            <div class="card-body">-->
<!--                <h5 class="card-title">Secondary card title</h5>-->
<!--                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
<!--            </div>-->
<!--            <div class="card-footer">Footer</div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-sm-6">-->
<!--        <div class="card text-white bg-success mb-3">-->
<!--            <div class="card-header">Header</div>-->
<!--            <div class="card-body">-->
<!--                <h5 class="card-title">Success card title</h5>-->
<!--                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
<!--            </div>-->
<!--            <div class="card-footer">Footer</div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-sm-6">-->
<!--        <div class="card text-white bg-danger mb-3">-->
<!--            <div class="card-header">Header</div>-->
<!--            <div class="card-body">-->
<!--                <h5 class="card-title">Danger card title</h5>-->
<!--                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
<!--            </div>-->
<!--            <div class="card-footer">Footer</div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-sm-6">-->
<!--        <div class="card text-white bg-warning mb-3">-->
<!--            <div class="card-header">Header</div>-->
<!--            <div class="card-body">-->
<!--                <h5 class="card-title">Warning card title</h5>-->
<!--                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
<!--            </div>-->
<!--            <div class="card-footer">Footer</div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-sm-6">-->
<!--        <div class="card text-white bg-info mb-3">-->
<!--            <div class="card-header">Header</div>-->
<!--            <div class="card-body">-->
<!--                <h5 class="card-title">Info card title</h5>-->
<!--                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
<!--            </div>-->
<!--            <div class="card-footer">Footer</div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-sm-6">-->
<!--        <div class="card bg-light mb-3">-->
<!--            <div class="card-header">Header</div>-->
<!--            <div class="card-body">-->
<!--                <h5 class="card-title">Light card title</h5>-->
<!--                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
<!--            </div>-->
<!--            <div class="card-footer">Footer</div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-sm-6">-->
<!--        <div class="card text-white bg-dark mb-3">-->
<!--            <div class="card-header">Header</div>-->
<!--            <div class="card-body">-->
<!--                <h5 class="card-title">Dark card title</h5>-->
<!--                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
<!--            </div>-->
<!--            <div class="card-footer">Footer</div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
