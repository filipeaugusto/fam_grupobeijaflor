<?php
$this->start('tb_actions');

foreach ($categories as $key => $category) {
    echo $this->Html->tag('li', $this->Html->link(__($category->name), ['controller' => 'ShoppingCarts', 'action' => 'add', $partner->id, '?' => ['category_id' => $category->id]], ['class' => 'nav-link', 'escape' => false]));
}

$this->end();

$this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>');

