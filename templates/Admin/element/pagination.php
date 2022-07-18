<ul class="pagination">
    <?= $this->Paginator->first('<< ' . __('First')) ?>
    <?= $this->Paginator->prev('< ' . __('Previous')) ?>
    <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
    <?= $this->Paginator->next(__('Next') . ' >') ?>
    <?= $this->Paginator->last(__('Last') . ' >>') ?>
</ul>
<p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
