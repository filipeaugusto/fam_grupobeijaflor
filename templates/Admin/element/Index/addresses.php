<?php
if ($data->has('address')) {
    echo $this->Html->link('<i class="bi bi-geo-alt"></i>',
        '#modalBackoffice',
        [
            'escape' => false,
            'class' => 'btn btn-success',
            'title' => __('Addresses'),
            'data-toggle' => 'modal',
            'data-target' => '#modalBackoffice',
            'data-remote' => $this->Url->build(['controller' => 'addresses', 'action' => 'edit', $data->address->id]),
        ]
    );
} else {
    echo $this->Html->link('<i class="bi bi-geo-alt"></i>',
        '#modalBackoffice',
        [
            'escape' => false,
            'class' => 'btn btn-primary',
            'title' => __('Addresses'),
            'data-toggle' => 'modal',
            'data-target' => '#modalBackoffice',
            'data-remote' => $this->Url->build(['controller' => 'addresses', 'action' => 'add', $this->getRequest()->getParam('controller'), $data->id]),
        ]
    );
}
?>
