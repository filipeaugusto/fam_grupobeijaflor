<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Billing[]|\Cake\Collection\CollectionInterface $billingSlips
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="row mt-5 mb-5">
    <div class="col-md-12">
        <?= $this->Form->create($billingSlip, ['type' => 'post', 'class' => 'form-filter']); ?>
        <?= $this->Html->tag('div',
//            $this->Form->control('limit_deadline', ['empty' => 'Todos', 'default' => '', 'label' => 'Prazo final (dias)', 'required' => false,  'options' => array_combine(range(15,90, 15), range(15,90, 15))]) .
//            $this->Form->control('type', ['empty' => 'Todos', 'default' => '', 'required' => false,  'options' => ['input' => __('Input'), 'output' => __('Output')]]) .
            $this->Form->control('confirmation', ['empty' => 'Todos', 'default' => '', 'label' => 'Confirmado', 'required' => false, 'options' => [__('No'), __('Yes')]]) .
            $this->Form->control('description', ['required' => false, 'type' => 'text']) .
            $this->Form->control('invoice_number', ['required' => false, 'type' => 'text']) .
            $this->Form->control('value', ['required' => false, 'min' => '0.01', 'step' => '0.01']) .
            $this->Form->control('start_deadline', ['required' => false, 'type' => 'date']) .
            $this->Form->control('end_deadline', ['required' => false, 'type' => 'date']) .
            $this->Form->button(__('Filtrar'), ['style' => 'margin-top: 15px; margin-left: 5px']),
            ['class' => 'form-row align-items-center']
        ); ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col" style="width: 70px;"><?= $this->Paginator->sort('type') ?></th>
            <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
            <th scope="col"><?= $this->Paginator->sort('id', 'Parceiro / Usuário') ?></th>
            <th scope="col"><?= $this->Paginator->sort('descricao', __('Descrição')) ?></th>
            <th scope="col"><?= $this->Paginator->sort('deadline') ?></th>
            <th scope="col"><?= $this->Paginator->sort('value') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col" class="actions text-center" colspan="2"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($billingSlips as $k => $billingSlip) : ?>
            <tr id="<?= h($billingSlip->id) ?>" title="<?= h($billingSlip->has('account') ? $billingSlip->account->details : $billingSlip->description) ?>">
                <td>
                    <?php if (!$billingSlip->confirmation) { ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="<?= $k; ?>" value="<?= $billingSlip->id; ?>" name="<?= $billingSlip->id; ?>">
                        <label class="form-check-label" for="<?= $k; ?>" style="margin-top: 3px"><i class="bi bi-arrows-collapse text-info"></i></label>
                    </div>
                    <?php } else { ?>
                        <i class="bi bi-arrows-collapse text-info" style="margin-left: 17px"></i>
                    <?php } ?>
                </td>
                <td>
                    <?= $this->Backoffice->orderFilterBy($billingSlip->company) ?>
                    <?= $billingSlip->has('company') ? $this->Html->link($this->Backoffice->truncate($billingSlip->company->name, 32), ['controller' => 'Companies', 'action' => 'view', $billingSlip->company->id], ['title' => $billingSlip->company->name]) : '' ?>
                </td>
                <td>
                    <?php
                    if ($billingSlip->has('partner')) {
                        echo $this->Backoffice->orderFilterBy($billingSlip->partner);
                        echo $this->Html->link($this->Backoffice->truncate($billingSlip->partner->name, 32), ['controller' => 'partners', 'action' => 'view', $billingSlip->partner_id], ['title' => $billingSlip->partner->name]);
                    }
                    if ($billingSlip->has('user')) {
                        echo $this->Backoffice->orderFilterBy($billingSlip->user);
                        echo $this->Html->link($this->Backoffice->truncate($billingSlip->user->name, 32), ['controller' => 'users', 'action' => 'view', $billingSlip->user_id], ['title' => $billingSlip->user->name]);
                    }
                    ?>
                </td>
                <td title="<?= $billingSlip->description ?>"><?= $this->Backoffice->truncate($billingSlip->description, 32); ?></td>
                <td><?= h($billingSlip->deadline) ?></td>
                <td><?= $this->Backoffice->currency($billingSlip->value) ?></td>
                <td><?= h($billingSlip->created) ?></td>
                <td style="padding-left: 0px; padding-right: 0px"><?= $this->Backoffice->archive($billingSlip->archive) ?></td>
                <td class="actions">

                    <?php if (!$billingSlip->authorization) { ?>
                        <?= $this->Form->postLink('<i class="bi bi-journal"></i>', ['action' => 'authorization', $billingSlip->id], ['escape' => false, 'class' => 'btn btn-outline-secondary', 'title' => __('Pending authorization')]) ?>
                    <?php } else { ?>
                        <?= $this->Form->postLink('<i class="bi bi-journal-check"></i>', ['action' => 'authorization', $billingSlip->id], ['escape' => false, 'class' => __('btn btn-success {0}', !$billingSlip->confirmation ?: 'disabled'), 'title' => __('Authorization')]) ?>
                    <?php } ?>

                    <?php if (!$billingSlip->confirmation) { ?>
                        <?php
                        echo $this->Html->link('<i class="bi bi-clipboard"></i>',
                            '#modalBackoffice',
                            [
                                'escape' => false,
                                'class' => __('btn btn-outline-secondary {0}', $billingSlip->authorization ?: 'disabled'),
                                'title' => __('Pending confirmation'),
                                'data-toggle' => 'modal',
                                'data-target' => '#modalBackoffice',
                                'data-remote' => $this->Url->build(['action' => 'waiting', $billingSlip->id]),
                            ]
                        );
                        ?>
                    <?php } else { ?>
                        <?= $this->Form->postLink('<i class="bi bi-clipboard-check"></i>', ['action' => 'confirmation', $billingSlip->id], ['escape' => false, 'class' => 'btn btn-success', 'title' => __('Confirmation')]) ?>
                    <?php } ?>

                    <?php echo $this->element('table-actions', ['data' => $billingSlip]); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9" style="padding-left: 0px">
                    <button type="button" class="btn btn-success" onclick="getSelectedCheckboxValues();">Confirmar selecionados</button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="paginator">
    <?php echo $this->element('pagination'); ?>
</div>
<style>
    form.form-filter div.form-group {
        margin-left: 5px;
        min-width: 200px;
    }
</style>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmar selecionados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= $this->Form->create(null, ['url' => ['action' => 'confirm-all']]) ?>
            <div class="modal-body">
                <?= $this->Form->control('account_id'); ?>
                <div id="parent">
                    Generated inputs:
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success">Confirmar selecionados</button>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
<script>
    function getSelectedCheckboxValues()
    {
        if( $("table input[type=checkbox].form-check-input").is(":checked") ) {

            const checkboxes = document.querySelectorAll('table input[type=checkbox].form-check-input:checked');
            let input;
            let parent = document.getElementById("parent");

            parent.innerHTML = '';

            checkboxes.forEach((checkbox, key) => {
                input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('value', checkbox.value);
                input.setAttribute('name', 'billings_slips[]');
                input.setAttribute('id', 'billings_slips-ids-' + checkbox.id);
                parent.appendChild(input);
            });

            $('#exampleModal').modal('show');

        } else {
            alert("Nenhum boleto de cobrança selecionado!!!");
            return false;
        }
        return false;
    }

</script>
