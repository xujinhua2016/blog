<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use Illuminate\Http\Request;

use App\Http\Model\Navs;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    //
    public function __construct()
    {
        $navs = Navs::orderBy('nav_order')->get();
        //点击量最高的文章，五篇
        $pics = Article::orderBy('art_view','desc')->take(5)->get();
        //最新发布文章，8篇
        $new = Article::orderBy('art_time','desc')->take(8)->get();
        
        View::share('navs',$navs);
        View::share('pics',$pics);
        View::share('new',$new);
    }
}
