<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Model\Entity\Company;
use App\Model\Entity\OrderStatus;
use App\Model\Entity\Partner;
use App\Model\Entity\User;
use Cake\ORM\Entity;
use Cake\View\Helper;
use Clemdesign\PhpMask\Mask;
use NumberFormatter;

/**
 * Backoffice helper
 * @property \Cake\View\Helper\TextHelper $Text
 * @property \Cake\View\Helper\HtmlHelper $Html
 * @property \Cake\View\Helper\UrlHelper $Url
 */
class BackofficeHelper extends Helper
{
    protected $helpers = ['Html', 'Text', 'Url'];

    public function initialize(array $config): void
    {
        parent::initialize($config);
    }

    /**
     * @param OrderStatus $orderStatus
     * @return string
     */
    public function orderStatus(OrderStatus $orderStatus): string
    {
        return "<a href='javascript:voi(0)' class='btn btn-sm btn-block' style='background-color: {$orderStatus->background_color}' title='{$orderStatus->name}'>
            <span style='color: {$orderStatus->font_color};'>{$orderStatus->name}</span>
        </a>";
    }

    /**
     * @param Entity $entity
     * @return string
     */
    public function orderFilterBy(Entity $entity): string
    {
        $query = [];
        $label = $entity->name ?? null;
        if ($entity instanceof OrderStatus) {
            $query = ['order_status_id' => $entity->id];
        }
        if ($entity instanceof User) {
            $query = ['user_id' => $entity->id];
        }
        if ($entity instanceof Partner) {
            $query = ['partner_id' => $entity->id];
        }
        if ($entity instanceof Company) {
            $query = ['company_id' => $entity->id];
        }

        if (is_array($this->Url->getView()->get('_searchParams')))
            $query = array_merge($this->Url->getView()->get('_searchParams'), $query);

        return $this->Html->link('<i class="bi bi-funnel"></i>',
            ['controller' => $this->getView()->getRequest()->getParam('controller'), 'action' => 'index', '?' => $query],
            ['title' => __('Filter orders by: {0}', $label), 'escape' => false, 'class' => 'text-secondary']
        );
    }

    /**
     * Formata como moeda um valor de acordo com as informações locais.
     *
     * @param float $val valor que será formatado
     * @return string
     */
    function currency(float $val): string
    {
        $fmt = new NumberFormatter(setlocale(LC_MONETARY, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese'), NumberFormatter::CURRENCY);
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $locale = localeconv();
        return $fmt->formatCurrency($val, $locale['int_curr_symbol']);
    }

    public function zipcode(string $zipcode): string
    {
        return Mask::apply($zipcode, '00000-000');
    }

    public function document(string $document): string
    {
        return Mask::apply($document, strlen($document) <= 11 ? '000.000.000-000' : '00.000.000/0000-00');
    }

    public function phone(?string $phone): string
    {
        return Mask::apply($phone, strlen($phone) >= 11 ? '(00) 00000-0000' : '(00) 0000-0000');
    }

    public function truncate(?string $text, $length = 8): string
    {
        if (is_null($text)) return '';

        return  $this->Text->truncate($text, $length, ['ellipsis' => ' ...', 'exact' => true]);
    }

    public function archive(?string $archive, array $options = []): string
    {
        if (is_null($archive)) return '';

        $array = explode('.', $archive);
        $ext = mb_strtolower(end($array));
        $folder = $options['folder'] ?? mb_strtolower($this->getView()->getName());
        $path = "/files/{$folder}/{$archive}";

        if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            return $this->Html->image($path, $options);
        } else {
            return $this->Html->link( '<i class="bi bi-cloud-arrow-down"></i>', $this->Url->build($path, ['fullBase' => true]), ['title' => __('Download file'), 'target' => '_blank', 'escape' => false, 'class' => 'btn btn-secondary']);
        }
    }
}
