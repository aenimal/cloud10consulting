<?php namespace Sterling\Repositories\Image;

use Sterling\Interfaces\RepositoryInterface;
use LaravelBook\Ardent\Ardent;

class Image extends Ardent implements ImageInterface, RepositoryInterface
{
	protected $table = 'images';

 	protected $fillable = array('filename');

    /**
     * Ardent validation rules
     *
     * @var array
     */
    public static $rules = array(
        'filename' 	         => 'required|max:255',
    );

    public function products()
    {
        // get the correct product class
        $product_class = \Auth::user()->company->product_class;
        return $this->belongsToMany('\Sterling\Repositories\Product\ClientProducts\\' . $product_class,'pivot_products_images','product_id','image_id');
    }

    public function publications()
    {
        return $this->belongsToMany('\Sterling\Repositories\Publication\Publication', 'pivot_publications_images', 'publication_id', 'image_id');
    }

    public function pages()
    {
        return $this->belongsToMany('\Sterling\Repositories\Pages\Pages', 'pivot_pages_images', 'publication_id', 'image_id');
    }

    public function getFilename()
    {

        $pos = strrpos($this->filename, "/");
        $filename = substr($this->filename, $pos + 1);

        return $filename;

    }

    public function getFilenameFromRoot()
    {

        $pos = strrpos($this->filename, "public");
        $filename = substr($this->filename, $pos + 6);

        return $filename;

    }



}