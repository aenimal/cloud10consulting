<?php namespace Sterling\Repositories\Page;

use Sterling\Interfaces\RepositoryInterface;
use Sterling\Factories;
use LaravelBook\Ardent\Ardent;

class Page extends Ardent implements PageInterface, RepositoryInterface
{
	protected $table = 'pub_pages';

 	protected $fillable = array('section_id','name','page_numbers','filename','style','production_stage','spread_reference','strapline','buyer','designer');

    /**
     * Ardent validation rules
     *
     * @var array
     */
    public static $rules = array(
        'section_id' 		=> 'required|numeric',
        'name' 	            => 'required|max:50',
    );

    // relationship
    public function section()
    {
        return $this->belongsTo('\Sterling\Repositories\Section\Section');
    }

    // relationship
    public function products()
    {
        // get the correct product class
        $product_class = $this->section->publication->company->product_class;

        return 
                $this   ->belongsToMany('\Sterling\Repositories\Product\ClientProducts\\' . $product_class,'pivot_pages_products','page_id','product_id')
                        ->withPivot('created_at AS attached_at');
    }

    // relationship
    public function graphics()
    {
        return $this->belongsToMany('\Sterling\Repositories\PageGraphic\PageGraphic','pivot_pages_graphics','page_id','graphic_id');
    }

    // relationship
    public function images()
    {
        return $this->belongsToMany('\Sterling\Repositories\Image\Image','pivot_pages_images','page_id','image_id');
    }

    public function last_attached_product()
    {
        return $this->products()->orderBy('attached_at','DESC')->first();
    }

}