<?php
/**
 * 2020
 *
 * NOTICE OF LICENSE
 *
 *  @author    Saidani Ahmed <saidaniahmed125@gmail.com>
 *  @copyright 2020
 *  @license   Commercial license (You can not resell or redistribute this software.)
 *
 */

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

include_once dirname(__FILE__).'/OutStock.php';

class OutOfStock extends Module implements WidgetInterface
{

    public function __construct()
    {
        $this->name = 'outofstock';
        $this->version = '1.0.0';
        $this->author = 'saidaniahmed125@gmail.com';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->tab = 'front_office_features';
        $this->controllers = array('outstock');

        parent::__construct();
        $this->displayName = $this->l('OutOfStock');
        $this->description = $this->l('Show products list back-in stock');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->defaults = array(
            'productsNb' => 0,
        );

    }

    public function install()
    {
        return parent::install()
            && $this->installDB()
            && $this->registerHook('actionUpdateQuantity')
            ;
    }

    public function installDB()
    {
        $return = true;
        $return &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'out_stock` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_shop` int(10) unsigned NOT NULL ,
                `id_product` int NOT NULL,
                `id_product_attribute` int,
                `date_update` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
                PRIMARY KEY (`id`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');


        return $return;
    }

    public function uninstall()
    {
        return
            $this->uninstallDB() &&
            parent::uninstall();
    }

    public function uninstallDB()
    {
        return Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'out_stock`');
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {

    }

    public function hookActionUpdateQuantity($params)
    {
        $id_product = (int) $params['id_product'];
        $id_product_attribute = (int) $params['id_product_attribute'];

        $quantity = (int) $params['quantity'];
        $context = Context::getContext();
        $id_shop = (int) $context->shop->id;

        if($quantity<1){
            $newStock=new OutStock();
            $newStock->id_product=$id_product;
            $newStock->id_product_attribute=$id_product_attribute;
            $newStock->id_shop=$id_shop;
            $newStock->date_update=date('Y-m-d');
            $newStock->add();
        }
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {


    }

}
