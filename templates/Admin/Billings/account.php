<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= __('Confirm {0}', __($billing->type)) ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="pills-company-tab" data-toggle="pill" href="#pills-company" role="tab" aria-controls="pills-company" aria-selected="false">
                <i class="bi bi-diagram-3"></i> <?= __('Companies') ?>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= $billing->model === null ?: 'disabled' ?>" id="pills-home-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-home" aria-selected="true">
                <i class="bi bi-person-badge"></i> <?= __('Users') ?>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link <?= $billing->model === null ?: 'disabled' ?>" id="pills-profile-tab" data-toggle="pill" href="#pills-partner" role="tab" aria-controls="pills-profile" aria-selected="false">
                <i class="bi bi-building"></i> <?= __('Partners') ?>
            </a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <h6><?= __('{0}: {1}', $billing->description, $billing->deadline) ?></h6>
        <div class="tab-pane fade show active" id="pills-company" role="tabpanel" aria-labelledby="pills-company-tab">
            <?= $this->Form->create($billing); ?>
                <?= $this->Form->hidden('model') ?>
                <?= $this->Form->control('deadline', ['empty' => false, 'required' => true, 'type' => 'date', 'label' => false]); ?>
                <?= $this->Form->control('account_id', ['options' => $accounts, 'required' => true, 'label' => false, 'empty' => __('Select one {0}...', __('account'))]) ?>
                <button type="submit" class="btn btn-success float-right"><?= __('Save changes') ?></button>
            <?= $this->Form->end(); ?>
        </div>
        <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-home-tab">
            <?= $this->Form->create($billing); ?>
                <?= $this->Form->hidden('model', ['value' => 'Users', 'label' => false]) ?>
                <?= $this->Form->control('account_id', ['options' => $accounts, 'required' => true, 'label' => false, 'empty' => __('Select one {0}...', __('company'))]) ?>
                <?= $this->Form->control('foreing_key', ['options' => $users, 'required' => true, 'label' => false, 'empty' => __('Select one {0}...', __('user'))]) ?>
                <button type="submit" class="btn btn-success float-right"><?= __('Save changes') ?></button>
            <?= $this->Form->end(); ?>
        </div>
        <div class="tab-pane fade" id="pills-partner" role="tabpanel" aria-labelledby="pills-profile-tab">
            <?= $this->Form->create($billing); ?>
                <?= $this->Form->hidden('model', ['value' => 'Partners', 'label' => false]) ?>
                <?= $this->Form->control('account_id', ['options' => $accounts, 'required' => true, 'label' => false, 'empty' => __('Select one {0}...', __('company'))]) ?>
                <?= $this->Form->control('foreing_key', ['options' => $partners, 'required' => true, 'label' => false, 'empty' => __('Select one {0}...', __('partner'))]) ?>
                <button type="submit" class="btn btn-success float-right"><?= __('Save changes') ?></button>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
<!--<div class="modal-footer">-->
<!--    <button type="button" class="btn btn-secondary" data-dismiss="modal">--><?//= __('Close') ?><!--</button>-->
<!--</div>-->

