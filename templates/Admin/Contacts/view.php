<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact $contact
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php echo $this->element('menu-actions'); ?>

<div class="contacts view large-9 medium-8 columns content">
    <h3><?= h($contact->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-hover">
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Backoffice->truncate($contact->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Partner') ?></th>
                <td><?= $contact->has('partner') ? $this->Html->link($contact->partner->name, ['controller' => 'Partners', 'action' => 'view', $contact->partner->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($contact->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Email') ?></th>
                <td><?= h($contact->email) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Phone') ?></th>
                <td><?= $this->Backoffice->phone($contact->phone) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Observations') ?></th>
                <td><?= h($contact->observations) ?></td>
            </tr>
              <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($contact->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($contact->modified) ?></td>
            </tr>
        </table>
    </div>
    <?= $this->Html->link(__('Go back'), ['action' => 'index'], ['class' => 'btn btn-secondary float-right']) ?>
</div>
