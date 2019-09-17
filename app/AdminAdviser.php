<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class AdminAdviser extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    protected $table;
    protected $primaryKey;
    protected $guarded =array();

    public function __construct(array $attributes = array())
	{
	    parent::__construct($attributes);

	    	$this->table 		=  config('constants.db.prefix').config('constants.db.user'); 
	    	$this->primaryKey   =  config('constants.db.user').'_id';
	    	$this->guarded  =  [config('constants.db.user').'_fname',config('constants.db.user').'_lname',config('constants.db.user').'_email',config('constants.db.user').'_password',config('constants.db.user').'_phone'];
	}


	public $timestamps = false;
}
?>
