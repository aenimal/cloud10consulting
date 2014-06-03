<?php namespace Sterling\Repositories\ProductImage;

use Sterling\Repositories\Image\Image;
use LaravelBook\Ardent\Ardent;

class ProductImage extends Image
{
    protected $table = 'pub_images';
    protected $fillable = array('publication_id', 'filename');

    public static $rules = array(
        'publication_id'     => 'required|numeric',
        'filename'           => 'required|max:100',
    );

    // relationship
    public function product()
    {
        return $this->belongsToMany('\Sterling\Repositories\Product\Product','pivot_products_images');
    }
    
}
