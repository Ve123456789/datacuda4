<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class AdminHomethird extends Model
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
        
        $this->table 		= config('constants.db.prefix').'homethird'; 
        $this->primaryKey   = 'homethird_id';
        $this->guarded  =  [
            'homethird_heading',
            'homethird_image',
            'homethird_status'
        ];
        
	}
    public $timestamps = false;
    
    public static function searchHeading($search_heading){
        
        return AdminHomethird::where('homethird_heading', 'like', '%'.$search_heading.'%')
            ->orderBy('homethird_id',"desc")
            ->paginate(6);
    }
    
    public static function getAllData(){
        
        return  AdminHomethird::orderBy('homethird_id',"desc")
        ->paginate(6);
    }
}
?>
