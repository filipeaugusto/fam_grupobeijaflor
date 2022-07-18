<?php

use Cake\Utility\Inflector;

$this->start('tb_actions');
$controllers = [
//    'banks' => ['icon' => '<i class="bi bi-bank2"></i>', 'label' => 'banks'],
    'companies' => ['icon' => '<i class="bi bi-diagram-3"></i>', 'label' => 'companies'],
    'accounts' => ['icon' => '<i class="bi bi-wallet"></i>', 'label' => 'accounts'],
    'file_imports' => ['icon' => '<i class="bi bi-file-earmark-arrow-up"></i>', 'label' => 'file_imports'],
    'check_controls' => ['icon' => '<i class="bi bi-cash"></i>', 'label' => 'check_controls'],
    'expense_categories' => ['icon' => '<i class="bi bi-list-check"></i>', 'label' => 'expense_categories'],
    'payments' => ['icon' => '<i class="bi bi-credit-card"></i>', 'label' => 'payments'],
    'billings' => ['icon' => '<i class="bi bi-calculator"></i>', 'label' => 'billings'],
    'billing_slips' => ['icon' => '<i class="bi bi-file-pdf"></i>', 'label' => 'billing_slips'],
    'partner_types' => ['icon' => '<i class="bi bi-award"></i>', 'label' => 'partner_types'],
    'partners' => ['icon' => '<i class="bi bi-building"></i>', 'label' => 'partners'],
    'contacts' => ['icon' => '<i class="bi bi-people"></i>', 'label' => 'contacts'],
    'categories' => ['icon' => '<i class="bi bi-bar-chart-steps"></i>', 'label' => 'categories'],
    'products' => ['icon' => '<i class="bi bi-upc-scan"></i>', 'label' => 'products'],
    'shopping_carts' => ['icon' => '<i class="bi bi-cart"></i>', 'label' => 'shopping_carts'],
//    'shopping_cart_items' => ['icon' => '<i class="bi bi-cart-fill"></i>', 'label' => 'shopping_cart_items'],
    'order_status' => ['icon' => '<i class="bi bi-clipboard-check"></i>', 'label' => 'order_status'],
    'orders' => ['icon' => '<i class="bi bi-clipboard"></i>', 'label' => 'orders'],
//    'order_products' => ['icon' => '<i class="bi bi-bag-fill"></i>', 'label' => 'order_products'],
//    'order_evolutions' => ['icon' => '<i class="bi bi-clipboard-data"></i>', 'label' => 'order_evolutions'],
//    'addresses' => ['icon' => '<i class="bi bi-geo-alt"></i>', 'label' => 'addresses'],
//    'attachments' => ['icon' => '<i class="bi bi-tags"></i>', 'label' => 'attachments'],
    'rules' => ['icon' => '<i class="bi bi-gear"></i>', 'label' => 'rules'],
    'users' => ['icon' => '<i class="bi bi-person-badge"></i>', 'label' => 'users'],
];
foreach ($controllers as $key => $controller) {
    echo $this->Html->tag('li', $this->Html->link(__('{0} {1}', $controller['icon'], __(Inflector::camelize($controller['label']))), ['controller' => $key, 'action' => 'index'], ['class' => 'nav-link', 'escape' => false]));
}

$this->end();

$this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>');

