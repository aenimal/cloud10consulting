<?php 

namespace Sterling\Repositories\Publication;

use Sterling\Repositories\Section\Section;
use Sterling\Repositories\Product\Product;
use Sterling\Interfaces\RepositoryInterface;
use LaravelBook\Ardent\Ardent;

class Publication extends Ardent implements PublicationInterface, RepositoryInterface
{
	protected $table = 'publications';

 	protected $fillable = array('company_id','name', 'description','type');

    /**
     * Ardent validation rules
     *
     * @var array
     */
    public static $rules = array(
        'company_id'    => 'required|numeric', 
        'name'      	=> 'required|max:50', 
        'type'          => 'in:single_page,dps,section',
    );

    // relationship
    public function company()
    {
        return $this->belongsTo('\Sterling\Repositories\Company\Company');
    }
    
    // relationship
    public function sections()
    {
        return $this->hasMany('\Sterling\Repositories\Section\Section');
    }

    // relationship
    public function images()
    {
        return $this->belongsToMany('\Sterling\Repositories\Image\Image','pivot_publications_images','publication_id','image_id');
    }
    
    // relationship
    public function pages()
    {
        return $this->hasManyThrough('\Sterling\Repositories\Page\Page', '\Sterling\Repositories\Section\Section');
    }
    
    // relationship
    public function products()
    {
        // get the correct product class
        $product_class = $this->company->product_class;
        return $this->hasMany('\Sterling\Repositories\Product\ClientProducts\\' . $product_class);
    }

}





