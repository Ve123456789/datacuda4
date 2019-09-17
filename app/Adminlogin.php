<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Adminlogin extends Model
{
   

    protected $table;

    public function __construct(array $attributes = array())
	{
	    parent::__construct($attributes);

	    	$this->table =  config('constants.db.prefix').config('constants.db.user'); 
	}


	/*public function getTable()
    {
        if ($table = config('constants.db.prefix').config('constants.db.user'))
        {
            return $table;
        }
        return parent::getTable();
    }*/


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    
    public $timestamps = false;
}
?>
