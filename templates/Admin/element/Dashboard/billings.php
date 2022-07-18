<div class="table-responsive-sm">
    <table class="table table-sm text-left">
        <tbody>
            <tr class="font-weight-bold text-success">
                <td style="width: 250px"><?= __('Inputs') ?></td>
                <td>
                    <?= $this->Backoffice->currency($data->getInput()) ?>
                    <?php if($data->getInputCheck() > 0) { ?>
                        <span class="small text-info">(Dinheiro: <?= $this->Backoffice->currency($data->getInput() - $data->getInputCheck()) ?>)</span>
                    <?php } ?>
                </td>
            </tr>
            <?php if ($data->getWaitingForInput() > 0) { ?>
                <tr class="text-secondary" style="color: #93bf9d !important">
                    <td><?= __('Waiting for input') ?></td>
                    <td><?= $this->Backoffice->currency($data->getWaitingForInput()) ?></td>
                </tr>
            <?php } ?>
            <tr class="font-weight-bold text-danger">
                <td><?= __('Outputs') ?></td>
                <td><?= $this->Backoffice->currency($data->getOutput()) ?></td>
            </tr>
            <?php if ($data->getWaitingForOutput() > 0) { ?>
                <tr class="text-secondary" style="color: #deadb2 !important">
                    <td><?= __('Waiting for output') ?></td>
                    <td><?= $this->Backoffice->currency($data->getWaitingForOutput()) ?></td>
                </tr>
            <?php } ?>
            <?php if ($data->getWaiting() > 0) { ?>
                <tr class="text-secondary">
                    <td><?= __('Waiting') ?></td>
                    <td><?= $this->Backoffice->currency($data->getWaiting()) ?></td>
                </tr>
            <?php } ?>
            <tr class="font-weight-bold <?= $data->getResult() >= 0 ? 'text-info' : 'text-danger' ?>">
                <td><?= __('Results') ?></td>
                <td><?= $this->Backoffice->currency($data->getResult()) ?></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="progress mt-3  <?= $data->isProgress() ?: 'invisible mt-0'; ?>">
    <div class="progress-bar progress-bar-striped bg-danger" title="<?= number_format($data->getPercentage(), 2) ?>%" role="progressbar" style="width: <?= h($data->getPercentage()) ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
</div>
