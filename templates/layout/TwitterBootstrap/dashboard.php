<?php
/**
 * @var \Cake\View\View $this
 */

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Utility\Inflector;

$this->Html->css(['starter-template', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css'], ['block' => true]);
$this->Html->script(['jquery.mask', 'consulta-cep', 'consulta-cat-transacao'], ['block' => true]);
$this->prepend('tb_body_attrs', ' class="' . implode(' ', [$this->getRequest()->getParam('controller'), $this->getRequest()->getParam('action')]) . '" ');
$this->start('tb_body_start');

?>
<body <?= $this->fetch('tb_body_attrs') ?>>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" style="background-color: #003980 !important;">
        <?= $this->Html->image('logo.png', ['url' => '/admin', 'class' => 'navbar-brand', 'style' => 'height:45px', 'alt' => Configure::read('App.title')]) ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link font-weight-bold" href="#"><?= $listOfCompanies[$this->getRequest()->getSession()->read('Config.company')] ?? __('All companies'); ?></a>
                </li>
                <li class="nav-item dropdown d-block d-md-none">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Áreas</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <?php
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
                                'categories' => ['icon' => '<i class="bi bi-bar-chart-steps"></i>', 'label' => 'categories'],
                                'products' => ['icon' => '<i class="bi bi-upc-scan"></i>', 'label' => 'products'],
                                //    'contacts' => ['icon' => '<i class="bi bi-people"></i>', 'label' => 'contacts'],
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
                            foreach ($controllers as $key => $menu) {
                                echo $this->Html->link(__(Inflector::camelize($menu['label'])), ['controller' => $key, 'action' => 'index'], ['class' => 'dropdown-item']);
                            }
                        ?>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= __('Change company') ?></a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <?php
                        echo $this->Html->link(__('All companies'), ['controller' => 'companies', 'action' => 'change', 'all'], ['class' => 'dropdown-item']);
                        foreach ($listOfCompanies as $key => $menu) {
                            echo $this->Html->link(__($menu), ['controller' => 'companies', 'action' => 'change', $key], ['class' => 'dropdown-item']);
                        }
                        ?>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= __('Welcome, {0}', $this->Identity->get('first_name')); ?></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                        <?= $this->Html->link(__('{0} Profile', '<i class="bi bi-file-earmark-person-fill"></i>'), ['controller' => 'users', 'action' => 'view', $this->Identity->get('id')], ['escape' => false,'class' => 'dropdown-item']); ?>
                        <?= $this->Html->link(__('{0} Logout', '<i class="bi bi-power"></i>'), ['controller' => 'users', 'action' => 'logout'], ['escape' => false, 'class' => 'dropdown-item text-danger']); ?>
                    </div>
                </li>
            </ul>
            <?= $this->Form->create(null, ['valueSources' => 'query', 'class' => 'form-inline my-2 my-lg-0']) ?>
                <?= $this->Form->control('q', ['class' => 'form-control mr-sm-2', 'placeholder' => __('Search'), 'label' => false]); ?>
                <?= $this->Form->button(__('Search'), ['class' => 'btn btn-secondary my-2 my-sm-0']) ?>
            <?= $this->Form->end() ?>
        </div>
    </nav>

    <div class="container-fluid mb-5">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <?= $this->fetch('tb_sidebar') ?>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 pt-4 mb-5">

                <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">

                    <?= $this->Search->isSearch() ? $this->Search->resetLink(__('Reset'), ['class' => 'btn btn-secondary btn-sm']) : null ?>
                    <?= $this->getRequest()->getQueryParams() && !$this->Search->isSearch() ? $this->Html->link(__('Reset'), ['action' => $this->getRequest()->getParam('action')], ['class' => 'btn btn-secondary btn-sm']) : null ?>

                    <?php
                        if ($this->getRequest()->getParam('controller') == 'ShoppingCarts' && $this->getRequest()->getParam('action') != 'index') {
                            echo $this->Html->link(__('{0} Go back', '<i class="bi bi-arrow-left"></i>'), ['controller' => 'ShoppingCarts', 'action' => 'index'], ['class' => 'btn btn-dark btn-sm', 'escape' => false]);
                        }
                    ?>

                    <?php if (!in_array($this->getRequest()->getParam('controller'), ['Pages'])) { ?>
                        <?= $this->Html->link(__('Export'), ['controller' => $this->getRequest()->getParam('controller'), 'action' => 'export', 'ext' => 'csv', '?' => ['q' => $this->request->getQuery('q')]], ['class' => 'btn btn-outline-secondary btn-sm']); ?>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= __('Options'); ?>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                                <?= $this->Html->link(__('List records'), ['controller' => $this->getRequest()->getParam('controller'), 'action' => 'index'], ['class' => 'dropdown-item']); ?>
                                <?= $this->Html->link(__('Add new record'), ['controller' => $this->getRequest()->getParam('controller'), 'action' => 'add'], ['class' => 'dropdown-item']); ?>
                                <?= in_array($this->getRequest()->getParam('controller'), ['Billings', 'BillingSlips']) ? $this->Html->link(__('Transactions conference'), ['controller' => $this->getRequest()->getParam('controller'), 'action' => 'conference'], ['class' => 'dropdown-item text-primary']) : null; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <h1 class="page-header"><?= __($title ?? Inflector::humanize($this->getRequest()->getParam('controller'))); ?></h1>
                <?php
                    if (!$this->fetch('tb_flash')) {
                        $this->start('tb_flash');
                        if (isset($this->Flash)) {
                            echo $this->Flash->render();
                        }
                        $this->end();
                    }
                    $this->end();

                    echo $this->fetch('content');
                ?>
            </main>
        </div>
    </div>

    <?php $this->start('tb_footer'); ?>
        <div class="modal fade" id="modalBackoffice" tabindex="-1" aria-labelledby="openModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                </div>
            </div>
        </div>
        <footer class="footer mt-auto py-3 fixed-bottom" style="background-color: #f5f5f5 !important">
            <div class="container-fluid">
                <span class="text-muted">
                    <?php
                    if (Configure::check('App.title')) {
                        printf('&copy;%s %s', date('Y'), Configure::read('App.title'));
                    } else {
                        printf('&copy;%s', date('Y'));
                    }
                    ?>
                </span>
            </div>
        </footer>
    <?php $this->end(); ?>

<?php
    $this->start('tb_body_end');

    echo "<script type='application/javascript'>
        $(document).ready(function() {
            $('input.date').mask('11/11/1111');
            $('input.time').mask('00:00:00');
            $('input.date_time').mask('00/00/0000 00:00:00');
            $('input.cep').mask('00000-000');
            $('input.phone').mask('0000-0000');
            $('input.phone_us').mask('(000) 000-0000');
            $('input.mixed').mask('AAA 000-S0S');
            $('input.cpf').mask('000.000.000-00', {reverse: true});
            $('input.money').mask('000.000.000.000.000,00', {reverse: true});

            var options = {
                onKeyPress: function (doc, ev, el, op) {
                    let masks = ['000.000.000-00#', '00.000.000/0000-00'];
                    $('input.document').mask((doc.length > 14) ? masks[1] : masks[0], op);
                }
            }

            if($('input.document').length){
                $('input.document').first().val().length >= 14
                    ? $('input.document').mask('00.000.000/0000-00', options)
                    : $('input.document').mask('000.000.000-00#', options);
            }

            var options = {
                onKeyPress: function (tel, ev, el, op) {
                    let masks = ['(00) 0000-0000#', '(00) 00000-0000'];
                    $('input.phone_with_ddd').mask((tel.length > 14) ? masks[1] : masks[0], op);
                }
            }

            if($('input.phone_with_ddd').length){
                $('input.phone_with_ddd').first().val().length >= 11
                    ? $('input.phone_with_ddd').mask('(00) 00000-0000', options)
                    : $('input.phone_with_ddd').mask('(00) 0000-0000#', options);
            }

            $('#modalBackoffice').on('show.bs.modal', function (e) {
                let button = $(e.relatedTarget);
                let modal = $(this);
                modal.find('.modal-content').load(button.data('remote'));
            });

            $('select.selectExpenseCategory').on('change', function() {
                pesquisacat(this.value);
            });

        });
    </script>";

    echo '</body>';

    $this->end();
?>


