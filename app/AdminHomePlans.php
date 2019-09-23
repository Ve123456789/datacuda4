<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class AdminHomePlans extends Model
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
        
        $this->table 		= config('constants.db.prefix').'homeplans'; 
        $this->primaryKey   = 'homeplans_id';
        $this->guarded  =  [
            'homeplans_heading',
            'homeplans_content',
            'homeplans_price',
            'homeplans_duration',
            'homeplans_image',
            'homeplans_status'
        ];
        
	}
    public $timestamps = false;
    
    public static function searchPlans($search_heading){
        
        return AdminHomePlans::where('homeplans_heading', 'like', '%'.$search_heading.'%')
            ->orderBy('homeplans_id',"desc")
            ->paginate(6);
    }
    
    public static function getAllData(){
        
        return  AdminHomePlans::orderBy('homeplans_id',"desc")
        ->paginate(6);
    }
}
?>
