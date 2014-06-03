<?php namespace Sterling\Repositories\Section;

use Sterling\Repositories\Publication\Publication;
use Sterling\Interfaces\RepositoryInterface;
use LaravelBook\Ardent\Ardent;

class Section extends Ardent implements SectionInterface, RepositoryInterface
{
	protected $table = 'pub_sections';

 	protected $fillable = array('publication_id','name');

    /**
     * Ardent validation rules
     *
     * @var array
     */
    public static $rules = array(
        'publication_id' 	=> 'required|numeric',
        'name' 	            => 'required|max:50',
    );

    // relationship
    public function publication()
    {
        return $this->belongsTo('\Sterling\Repositories\Publication\Publication');
    }

    // relationship
    public function pages()
    {
        return $this->hasMany('\Sterling\Repositories\Page\Page');
    }

    // relationship
    public function related_sections()
    {
        return $this->belongsToMany('\Sterling\Repositories\Section\Section', 'pivot_sections_sections', 'section_id', 'section_id_related');
    }


}