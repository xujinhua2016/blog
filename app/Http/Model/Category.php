<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table ='blog_category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];

    public function tree()
    {
        $categorys = $this->orderBy('cate_order','asc')->get();
        return $this->getTree($categorys,"cate_name",'cate_id','cate_pid',0);
    }
//    public static function tree()
//    {
//        $categorys = Category::all();
//        return (new Category)->getTree($categorys,"cate_name",'cate_id','cate_pid',0);
//    }
    public function getTree($date,$field_name,$field_id='id',$field_pid='pid',$pid=0)
    {
        $arr = array();
        foreach ($date as $k=>$v ){
            if ($v->$field_pid == $pid){
                $date[$k]["_".$field_name] = $date[$k][$field_name];
                $arr[] = $date[$k];
                foreach ($date as $m=>$n){
                    if ($n->$field_pid == $v->$field_id){
                        $date[$m]["_".$field_name] = '|--'.$date[$m][$field_name];
                        $arr[] = $date[$m];
                    }
                }
            }
        }
        return $arr;
    }

}
