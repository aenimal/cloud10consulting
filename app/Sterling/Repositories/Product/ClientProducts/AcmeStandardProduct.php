<?php namespace Sterling\Repositories\Product\ClientProducts;

use Sterling\Repositories\Product;

class AcmeStandardProduct extends \Sterling\Repositories\Product\Product{

    /**
     * Map of fillable fields against their lables
     * (used to build the 'fillable' and 'rules' arrays)
     *
     * @var array
     */
    public $fields = array(

        'sku'           => [
                            'type'      => 'string',    
                            'index'     => true,
                            'label'     => 'SKU',
                            'rules'     => 'required|max:10'
                            ],
        'name'          => [
                            'type'      => 'string',    
                            'index'     => true,
                            'label'    => 'Name',
                            'rules'     => 'required|max:50',
                            ],
        'colour'        => [
                            'type'      => 'enum',
                            'index'     => true,
                            'label'    => 'Colour',
                            'rules'     => 'in:Blue,Red,Green,Yellow',
                            'options'   => ['Blue','Red','Green','Yellow'],
                            ],
        'description'   => [
                            'type'      => 'text',      
                            'index'     => false,
                            'label'    => 'Description',
                            'rules'     => 'max:500',
                            ],
        'type'          => [
                            'type'      => 'string',    
                            'index'     => true,
                            'label'    => 'Type',
                            'rules'     => 'max:20',
                            ],
        'price_gbp'     => [
                            'type'      => 'decimal',   
                            'index'     => true,
                            'label'    => 'Price GBP',
                            'rules'     => 'numeric',
                            ],
        'price_eur'     => [
                            'type'      => 'decimal',   
                            'index'     => false,
                            'label'    => 'Price EUR',
                            'rules'     => 'numeric',
                            ],
        'features'      => [
                            'type'      => 'list',      
                            'index'     => false,
                            'label'    => 'Features',
                            'rules'     => 'max:500',
                            ],

    );


}