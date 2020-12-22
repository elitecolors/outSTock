<?php

class OutStock extends ObjectModel
{
    public $id;


    public $id_product;

    public $id_product_attribute;

    public $id_shop;

    public $date_update;


    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'out_stock',
        'primary' => 'id',
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'id_product_attribute' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'date_update' => array('type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate'),
        ),
    );



}
