<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class AdminHomebanner extends Model
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

	    	$this->table 		=  config('constants.db.prefix').config('constants.db.homebanner'); 
	    	$this->primaryKey   =  config('constants.db.homebanner').'_id';
	    	$this->guarded  =  [config('constants.db.homebanner').'_title',config('constants.db.homebanner').'_image',config('constants.db.homebanner').'_status'];
	}


    public $timestamps = false;
    
    public function getData(){
        return AdminHomebanner::where('status',1)->orderBy('homebanner_id','desc')->first();
    }
}
?>
