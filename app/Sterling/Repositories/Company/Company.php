<?php namespace Sterling\Repositories\Company;

use Sterling\Interfaces\RepositoryInterface;
use LaravelBook\Ardent\Ardent;

class Company extends Ardent implements CompanyInterface, RepositoryInterface
{
	protected $table = 'companies';

 	protected $fillable = array('name');

    /**
     * Ardent validation rules
     *
     * @var array
     */
    public static $rules = array(
        'name' 	            => 'required|max:100|unique:companies', // apparently we don't need 'companies' on the unique rule but it fails otherwise
    );

    // relationship
    public function users()
    {
        return $this->hasMany('User');
    }

    // relationship
    public function product_classes()
    {
        return \DB::table('product_classes')->where('company_id',$this->id)->lists('name');
    }

}