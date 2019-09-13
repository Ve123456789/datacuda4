<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class AdminHomesecond extends Model
{
    // public $tablePrefix = '';
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
        
        $this->table 		= config('constants.db.prefix').'homesecond'; 
        $this->primaryKey   = 'homesecond_id';
        $this->guarded  =  [
            'homesecond_heading1',
            'homesecond_heading2',
            'homesecond_heading3',
            'homesecond_image1',
            'homesecond_image2',
            'homesecond_image3',
            'homesecond_status'
        ];
        
	}
    public $timestamps = false;
    
    public static function searchHeading($search_heading){
        
        return AdminHomesecond::where('homesecond_heading1', 'like', '%'.$search_heading.'%')
			->orWhere('homesecond_heading2', 'like', '%'.$search_heading.'%')
			->orWhere('homesecond_heading3', 'like', '%'.$search_heading.'%')
            ->orderBy('homesecond_id',"desc")
            ->paginate(6);
    }
    
    public static function getAllData(){
        
        return  AdminHomesecond::orderBy('homesecond_id',"desc")
        ->paginate(6);
    }
}
?>
