<?php namespace Sterling\Repositories\User\Profile;

use Sterling\Repositories\Company\Company;
use Sterling\Interfaces\RepositoryInterface;
use LaravelBook\Ardent\Ardent;

class Profile extends Ardent implements ProfileInterface, RepositoryInterface
{
	protected $table = 'user_profiles';

	//protected $guarded = ['*'];
 	protected $fillable = array('user_id', 'firstname', 'lastname');

    /**
     * Ardent validation rules
     *
     * @var array
     */
    public static $rules = array(
        'user_id' 		=> 'required|numeric',
        'firstname' 	=> 'required|max:50',
        'lastname' 		=> 'required|max:50',
    );

    // relationship
    public function user()
    {
        return $this->belongsTo('User');
    }

    public function __get($property) {

        $getter = '_get_' . strtolower($property);

        if(method_exists($this, $getter)){

            return $this->$getter();

        }elseif(isset($this->attributes[$property])){
            return $this->attributes[$property];
        }

        return null;

    }

    private function _get_fullname()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

}