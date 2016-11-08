<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传验证
    public function upload()
    {
        $file = Input::file('Filedata');
        if ($file -> isValid()){
            //检验上传的文件是否有效
            //$clientName = $file->getClientOriginalName();//获取文件名称
            //$tmpName = $file->getFileName();//缓存在tmp文件夹中的文件名

            //$mineTye = $file->getMimeType();//获取文件的类型
            //$path = $file->move('storage/uploads');

           // $realPath = $file->getRealPath();//这个表示的是缓存在tmp文件夹下的文件的绝对路径，
            $entension = $file->getClientOriginalExtension();//上传文件的后缀

            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file->move(base_path().'/uploads',$newName);

            $filepath = 'uploads/'.$newName;
            return $filepath;

        }

    }
}
