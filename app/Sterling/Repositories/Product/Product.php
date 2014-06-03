<?php namespace Sterling\Repositories\Product;

use Sterling\Repositories\Publication\Publication;
use Sterling\Repositories\Page\Page;
use Sterling\Repositories\ProductImage\ProductImage;
use Sterling\Interfaces\RepositoryInterface;
use LaravelBook\Ardent\Ardent;

class Product extends Ardent implements ProductInterface, RepositoryInterface
{
	protected $table = 'pub_products';

    public $fields = [];     // field config - should be defined in child class
    protected $fillable = ['publication_id','parent_id'];   // fillable array is created dynamically in this controller

    public $field_types = [
        'string'    => ['schema_type'=>'string',    'rules'=>'max:255'],
        'text'      => ['schema_type'=>'text',      'rules'=>'max:1000'],
        'decimal'   => ['schema_type'=>'decimal',   'rules'=>'numeric'],
        'list'      => ['schema_type'=>'text',      'rules'=>'max:1000'], // for storing bullets etc.
        'enum'      => ['schema_type'=>'string',    'rules'=>'max:100'], // values are stored as strings, enum values only exist in the child class
    ];

    /**
     * Ardent validation rules
     *
     * @var array
     */
    public static $rules = []; // this gets over ridden during save($this->validation_rules)
    public $validation_rules = []; // used to override the above
    public $validation_messages = []; // used to pass field labels into the messages

    // // doesn't work with Ardent and can't access Validator::setAttributeNames
    // public $customAttributes = [
    //     'string1'   => 'SKU'
    // ];

    /**
    * Override the constructor so we can set various things based on the client product class
    */
    public function __construct(array $attributes = array()) 
    {
        $this->init();
        
        parent::__construct($attributes);
    }

    public function init()
    {
        $this->_parseFields();
    }

    /**
    *
    * Override the save function so we can pass the customised validation rules
    */
    public function save(
        array $rules = array(),
        array $customMessages = array(),
        array $options = array(),
        Closure $beforeSave = null,
        Closure $afterSave = null
    ) {
        //dd($this->validation_rules);
        //dd($this->validation_messages);
        // override the validation rules with the ones that were created during _parseFields
        return parent::save($this->validation_rules, $this->validation_messages);
    }


    /**
    *
    * magic method to get named variables like 'sku' and 'description' from the attributes 
    * when they are actually called things like string1, text3, decimal5 etc..
    *
    * @var string   - the name of the variable being requested
    */
    public function __get($key)
    {
        // is the requested keyiable in the fields array?
        if(isset($this->fields[$key]))
        {
            // if so, find out what it's database column name is
            $db_column_name = $this->fields[$key]['name'];
            // return $this->attributes->string1 (or text3, decimal5 etc.)
            if(isset($this->attributes[$db_column_name]))
                return $this->attributes[$db_column_name];
        
        // otherwise, check if its in the attributes as named (such as $this->id)
        }elseif(isset($this->attributes[$key])){
            return $this->attributes[$key];
        }

        return parent::__get($key);
    }


    /**
    * 
    * make any required updates to the fields array (such as adding db fieldnames)
    * - creates field names
    * - creates fillable array
    *
    */
    private function _parseFields()
    {
        // make a new array from the field_types array where all values are ZERO
        $num_types = array_fill_keys(array_keys($this->field_types), 0);

        // create a new fillable array
        $fillable = [];

        // loop fields
        foreach($this->fields as &$field_config){

            // DB FIELD NAME ---------------------------------------------------
            // get the schema type (eg: string, text etc.)
            $type = $this->field_types[$field_config['type']]['schema_type'];
            // create the field name based on the type and count
            $field_config['name'] = $type . (++$num_types[$type]);

            // FILLABLE ENTRIES ---------------------------------------------------
            // add a 'fillable' value like "string1", "decimal3" etc.
            $fillable[] = $field_config['name'];
            
            // VALIDATION RULES --------------------------------------------------
            // get the related rules from either the class fields or the field_types arrays
            $field_rules = isset($field_config['rules']) ? $field_config['rules'] : $this->field_types[$type]['rules'];            
            // store
            $this->validation_rules[$field_config['name']] = $field_rules;

            // VALIDATION MESSAGES
            // copy all the validation messages from the lang file into a 
            // FIELD specific array so we can swap all the attribute names out
            foreach(explode('|', $field_rules) as $field_rule){
                $rule_name = preg_replace('@:.*@','',$field_rule);
                $this->validation_messages[$field_config['name'].'.'.$rule_name] = $this->_swapValidationAttrs($rule_name, $field_config['label'], $field_rules);
            }

        }

        // merge the dynamic fillable fields with the defaults
        $merged_fillable = array_merge($this->fillable, $fillable);

        // set the fillable array using the appropriate parent method
        $this->fillable($merged_fillable);

    }

    private function _swapValidationAttrs($rule_name, $label, $field_rule)
    {
        $message = \Lang::get('validation.' . $rule_name);
        $message = str_replace(':attribute', $label, $message);
        // make sure we return the correct message for the type of rule (string, number, file)
        if(is_array($message)){
            $rule_type = strpos($field_rule, 'numeric') ? 'numeric' : 'string'; // TODO - only testing numeric/string at the moment, need to do file
            $message = $message[$rule_type];
        }
        return $message;
    }


    /**
    *
    * Seed the database based on what fields are in the child class
    *
    */
    public function seed($publication)
    {
        // required by seeding methods called below
        $this->faker = \Faker\Factory::create();

        // loop for 50 products
        for ($i = 0; $i < 50; $i++)
        {
            $content = [
                'publication_id'    => $publication->id
            ];

            $content = $this->_createProductContent($content);
            $parent = $this->create($content);

            if($parent)
            {
                if(count($parent->errors())) dd($parent->errors()->all());

                $num_children = floor(rand(0,10));

                // give this product between 0 and 10 children
                for($c=0; $c<$num_children; $c++)
                {
                    $child_content = [
                        'publication_id'    => $publication->id,
                        'parent_id'         => $parent->id
                    ];
                    $child_content = $this->_createProductContent($child_content);
                    $child = $this->create($child_content);
                    if(count($child->errors())) dd($child->errors()->all());
                }
            }
        }
    }  

    private function _createProductContent($content=array())
    {        
        $num_types = [];

        // loop fields in this product and call seeder methods for each one
        foreach($this->fields as $getter => $field)
        {            
            $field_type = $field['type'];
            $schema_type = $this->field_types[$field_type]['schema_type'];

            // increment the count of this type of field
            $num_types[$schema_type] = isset($num_types[$schema_type]) ? $num_types[$schema_type] + 1 : 1;

            // determine the seed method name
            $seed_method = '_seed_'.$field_type;
            $getter_seed_method = '_seed_'.$getter; // eg: _seed_sku()

            // check seed method exists
            if(method_exists($this, $getter_seed_method)){
                // assign the content (using the num_types to figure out the column name eg: string1)                
                $value = $this->$getter_seed_method($field);

            }elseif(method_exists($this, $seed_method)){
                // assign the content (using the num_types to figure out the column name eg: string1)                
                $value = $this->$seed_method($field);
            }else{
                $value = 'NOT SEEDED';
            }

            // truncate value if there is a max length rule to make sure it goes in
            if(strpos($field['rules'],'max:')>=0){
                // get length from rules (use lookbehind <= to find max: ebfore the number)
                $hasLength = preg_match('@(?<=max\:)\d+@is', $field['rules'], $match);
                $maxLength = $hasLength ? $match[0] : 0;
                // truncate
                $value = substr($value,0,$maxLength);
            }

            // assign the seeded value
            $content[$schema_type . $num_types[$schema_type]] = $value;
        }
        
        return $content;

    }

    private function _seed_sku($field){       return substr(strtoupper( $this->faker->word() ),0,3) . rand(100,999); }
    private function _seed_string($field){    return ucwords( implode(' ', $this->faker->words(3)) ); }
    private function _seed_text($field){      return $this->faker->paragraph(2); }
    private function _seed_decimal($field){   return number_format(rand(10,100),2); }
    private function _seed_list($field){      return implode("\n", $this->faker->sentences(rand(3,10))); }
    private function _seed_enum($field){      return $field['options'][ array_rand($field['options']) ]; }

    /**
    * Return a product with all attached pages OR a single page if an ID is provided
    * @param int Product ID
    * @param int Page ID
    */
    public function getProduct($product_id, $page_id=NULL)
    {
        return $page_id ? $this->getProductInPage($product_id, $page_id) : $this->find($product_id);
    }

    /**
    * Return a product with a single page instead of all pages it is attached to
    * @param int Product ID
    * @param int Page ID
    */
    public function getProductInPage($product_id, $page_id)
    {
        return $this->with(array(
            'pages' => function($query) use($page_id){
                $query->where('pub_pages.id', '=', $page_id);
            }
        ))->find($product_id);
    }

    /**
    *
    *
    */
    public function getIndexFields()
    {
        $index_fields = [];

        foreach($this->fields as $getter => $field){
            if(isset($field['index']) && $field['index']){
                $index_fields[$getter] = $field;
            }
        }

        return $index_fields;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    // RELATIONSHIPS
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    // relationship
    public function publication()
    {
        return $this->belongsTo('\Sterling\Repositories\Publication\Publication');
    }

    // relationship
    public function pages()
    {
        return $this->belongsToMany('\Sterling\Repositories\Page\Page','pivot_pages_products','product_id','page_id');
    }
    
    // relationship
    public function images()
    {
        return $this->belongsToMany('\Sterling\Repositories\Image\Image','pivot_products_images','product_id','image_id');
    }

    // relationship
    public function related_products()
    {
        return $this->belongsToMany('\Sterling\Repositories\Product\ClientProducts\AcmeStandardProduct','pivot_products_products','product_id','product_id_related');
    }

    // parent
    public function parent()
    {
        // get the correct product class
        $product_class = $this->publication->company->product_class;
        return $this->belongsTo('\Sterling\Repositories\Product\ClientProducts\\' . $product_class, 'parent_id', 'id');
    }

    // children
    public function children()
    {
        // get the correct product class
        $product_class = $this->publication->company->product_class;
        return $this->hasMany('\Sterling\Repositories\Product\ClientProducts\\' . $product_class, 'parent_id', 'id');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    // END RELATIONSHIPS
    ////////////////////////////////////////////////////////////////////////////////////////////////////
}