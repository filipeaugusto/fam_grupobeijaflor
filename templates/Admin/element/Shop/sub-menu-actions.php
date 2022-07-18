<div class="row mb-3 mt-3">
    <div class="col-md-12">
        <?php
            echo $this->Form->postLink(
                __('{0} {1}', '<i class="bi bi-trash"></i>', __('Clear')),
                ['controller' => 'ShoppingCarts', 'action' => 'delete', $shoppingCart->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $shoppingCart->id), 'escape' => false, 'class' => __('btn btn-danger float-left mr-3 {0}', $disabled ?? null)]
            );

            if (!is_null($this->request->getQuery('category_id'))) {

                $label = array_filter($categories, function ($cat) {
                    return $cat->id == $this->request->getQuery('category_id');
                }, ARRAY_FILTER_USE_BOTH);

                echo $this->Html->link(
                    __('{0} {1}', '<i class="bi bi-x"></i>', current($label)->name),
                    ['controller' => 'ShoppingCarts', 'action' => 'add', $this->request->getParam('pass')[0]],
                    ['escape' => false, 'class' => 'btn btn-outline-secondary float-left']
                );
            }

            echo $this->Html->link(
                __('{0} {1}', '<i class="bi bi-cash"></i>', $this->Backoffice->currency($shoppingCart->total_order ?? 0)),
                ['controller' => 'ShoppingCarts', 'action' => 'view', $shoppingCart->id],
                ['escape' => false, 'class' => __('btn btn-outline-success float-right ml-3 {0}', $disabled ?? null)]
            );

            echo $this->Html->link(
                __('{0} {1} {2}', '<i class="bi-cart-fill me-1"></i>', __('Shopping'), '<span class="badge bg-dark text-white ms-1 rounded-pill">'. ($shoppingCart->quantity_items ?? 0) .'</span>'),
                ['controller' => 'ShoppingCarts', 'action' => 'view', $shoppingCart->id],
                ['escape' => false, 'class' => __('btn btn-outline-dark float-right {0}', $disabled ?? null)]
            );
        ?>
    </div>
</div>
