<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class AboutUsPage extends Model
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
        
        $this->table 		= config('constants.db.prefix').'aboutus'; 
        $this->primaryKey   = 'aboutus_id';
        $this->guarded  =  [
            'aboutus_heading',
            'aboutus_content',
            'aboutus_image',
            'aboutus_section',
            'aboutus_status'
        ];
        
	}
    public $timestamps = false;
    
    public static function getAllData(){
        
        $aboutUsData = AboutUsPage::get();
        // if(!is_null($aboutUsData)){
        //     $aboutUsData = $aboutUsData->toArray();
        // }
        return $aboutUsData;
    }
}
?>
