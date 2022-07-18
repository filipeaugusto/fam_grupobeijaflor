<?php
$linkUp =__('{0} {1}', '<i class="bi bi-arrow-up-square"></i>',  $this->Html->tag('span', __('')));
$linkDown =__('{0} {1}', '<i class="bi bi-arrow-down-square"></i>',  $this->Html->tag('span', __('')));

$linkView =__('{0} {1}', '<i class="bi bi-file-earmark-text"></i>',  $this->Html->tag('span', __('View')));
$linkEdit =__('{0} {1}', '<i class="bi bi-pencil-square"></i>',  $this->Html->tag('span', __('Edit')));
$linkDelete =__('{0} {1}', '<i class="bi bi-trash"></i>',  $this->Html->tag('span', __('Delete')));

//dd($this->request->getQuery('page'));

?>

<?php if (isset($move) && $move === true){ ?>
    <?= $this->Html->link($linkUp, ['controller' => $controller ?? $this->request->getParam('controller'), 'action' => 'move', $data->id, 'up'], ['title' => __('Move up'), 'class' => 'btn btn-info', 'escape' => false]) ?>
    <?= $this->Html->link($linkDown, ['controller' => $controller ?? $this->request->getParam('controller'), 'action' => 'move', $data->id, 'down'], ['title' => __('Move down'), 'class' => 'btn btn-info mr-1', 'escape' => false]) ?>
<?php } ?>
<?php /*
<?= $this->Html->link($linkView, ['controller' => $controller ?? $this->request->getParam('controller'), 'action' => 'view', $data->id], ['title' => __('View'), 'class' => 'btn btn-secondary mr-1', 'escape' => false]) ?>
<?= $this->Html->link($linkEdit, ['controller' => $controller ?? $this->request->getParam('controller'), 'action' => 'edit', $data->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary mr-1', 'escape' => false]) ?>
<?= $this->Form->postLink($linkDelete, ['controller' => $controller ?? $this->request->getParam('controller'), 'action' => 'delete', $data->id], ['confirm' => __('Are you sure you want to delete # {0}?', $data->id), 'title' => __('Delete'), 'class' => 'btn btn-danger mr-1', 'escape' => false]) ?>
*/
?>
<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
    <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= __('Actions'); ?>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
            <?= $this->Html->link($linkView, ['controller' => $controller ?? $this->request->getParam('controller'), 'action' => 'view', $data->id], ['title' => __('View'), 'class' => 'dropdown-item', 'escape' => false]) ?>
            <?= $this->Html->link($linkEdit, ['controller' => $controller ?? $this->request->getParam('controller'), 'action' => 'edit', $data->id, '?' => ['page' => $this->request->getQuery('page') ?? 1]], ['title' => __('Edit'), 'class' => 'dropdown-item', 'escape' => false]) ?>
            <?= $this->Form->postLink($linkDelete, ['controller' => $controller ?? $this->request->getParam('controller'), 'action' => 'delete', $data->id], ['confirm' => __('Are you sure you want to delete # {0}?', $data->id), 'title' => __('Delete'), 'class' => 'dropdown-item text-danger', 'escape' => false]) ?>
        </div>
    </div>
</div>
