<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class AdminHomeReviews extends Model
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
        
        $this->table 		= config('constants.db.prefix').'homereviews'; 
        $this->primaryKey   = 'homereviews_id';
        $this->guarded  =  [
            'homereviews_user',
            'homereviews_review',
            'homereviews_image',
            'homereviews_status'
        ];
        
	}
    public $timestamps = false;
    
    public static function searchReviews($search_heading){
        
        return AdminHomeReviews::where('homereviews_review', 'like', '%'.$search_heading.'%')
            ->orderBy('homereviews_id',"desc")
            ->paginate(6);
    }
    
    public static function getAllData(){
        
        return  AdminHomeReviews::orderBy('homereviews_id',"desc")
        ->paginate(6);
    }
}
?>
