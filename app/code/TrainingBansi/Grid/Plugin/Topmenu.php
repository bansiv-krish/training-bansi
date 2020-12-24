<?php
namespace TrainingBansi\Grid\Plugin;
 
class Topmenu
{
   
    public function __construct(
        \Magento\Customer\Model\Session $session
    ) {
        $this->Session = $session;
    }
    public function afterGetHtml(\Magento\Theme\Block\Html\Topmenu $topmenu, $html)
    {
        $swappartyUrl = $topmenu->getUrl('frontgrid/index/index/');//here you can set link
        $magentoCurrentUrl = $topmenu->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
        if (strpos($magentoCurrentUrl, 'frontgrid/index/index/') !== false) {
            $html .= "<li class=\"level0 nav-5 active level-top ui-menu-item\">";
        } else {
            $html .= "<li class=\"level0 nav-4 level-top ui-menu-item\">";
        }
        $html .= "<a href=\"" . $swappartyUrl . "\" class=\"level-top ui-corner-all\"><span class=\"ui-menu-icon ui-icon ui-icon-carat-1-e\"></span><span>" . __("Posts") . "</span></a>";
        $html .= "</li>";
        return $html;
    }
}
