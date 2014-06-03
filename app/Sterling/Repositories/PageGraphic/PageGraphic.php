<?php namespace Sterling\Repositories\PageGraphic;

use Sterling\Repositories\Image\Image;
use LaravelBook\Ardent\Ardent;

class PageGraphic extends Image
{
    protected $table = 'pub_graphics';
    protected $fillable = array('publication_id', 'filename');

    public static $rules = array(
        'publication_id'     => 'required|numeric',
        'filename'           => 'required|max:100',
    );

    // relationship
    public function product()
    {
        return $this->belongsToMany('\Sterling\Repositories\Page\Page','pivot_pages_graphics');
    }
    
}
