<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    // //get admin/article  全部文章列表
    public function index() {
        $data = Article::orderBy('art_id','desc')->paginate(6);
        return view('admin.article.index',compact('data'));
    }

    //get admin/article/create  添加文章
    public function create() {
        //$data = [];
        $data = (new Category)->tree();
        return view('admin.article.add',compact('data'));
    }

    //post admin/article 添加文章提交
    public function store() {
        $input = Input::except('_token');
        $input['art_time'] = time();

        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
        ];
        $message = [
            'art_title.required'=>'文章名称不能为空',
            'art_content.required'=>'文章内容不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);

        if ($validator->passes()){;
            //入库操作
            $re = Article::create($input);
            if ($re) {
                return redirect('admin/article');
            }else{
                return back()->with('errors','数据填充失败，请稍后重试');
            }
        }else{
            return back()->withErrors($validator);
        }

    }

    //get admin/article/{article}/edit  编辑文章
    public function edit($art_id) {
        $data = (new Category)->tree();
        $field = Article::find($art_id);
        //return $field;
        return view('admin.article.edit',compact('data','field'));
    }

    //put|patch admin/article/{article}  更新文章
    public function update($art_id) {
        $input = Input::except('_token','_method');
        $re = Article::where('art_id',$art_id)->update($input);
        if ($re){
            return redirect('admin/article');
        }else{
            return back()->with('errors','文章信息更新失败，请稍后重试');
        }
    }

    //delete admin/article/{category}  删除文章
    public function destroy($art_id) {
        $re = Article::where('art_id',$art_id)->delete();
        if ($re){
            $data = [
                'status' => 0,
                'msg' => '文章删除成功!',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '文章删除失败,请稍后重试!',
            ];
        }
        return $data;
    }
}
