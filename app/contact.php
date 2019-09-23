<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    public static function searchHeading($search_heading){
        
        return contact::where('description', 'like', '%'.$search_heading.'%')
            ->orderBy('id',"desc")
            ->paginate(6);
    }
    
    public static function getAllData(){
        
        return  contact::orderBy('id',"desc")
        ->paginate(6);
    }
}
