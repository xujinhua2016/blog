@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 自定义导航管理
</div>
<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <div class="result_title">
            <h3>自定义导航列表</h3>
        </div>
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>添加导航</a>
                <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>全部导航</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%">排序</th>
                    <th class="tc" width="5%">ID</th>
                    <th>导航名称</th>
                    <th>别名</th>
                    <th>导航地址</th>
                    <th>操作</th>
                </tr>

                @foreach($data as $v)
                <tr>
                    <td class="tc">
                        <input type="text" onchange="changeOrder(this,{{$v->nav_id}})" value="{{$v->nav_order}}">
                    </td>
                    <td class="tc">{{$v->nav_id}}</td>
                    <td>
                        <a href="#">{{$v->nav_name}}</a>
                    </td>
                    <td>{{$v->nav_alias}}</td>
                    <td>{{$v->nav_url}}</td>
                    <td>
                        <a href="{{url('admin/navs/'.$v->nav_id.'/edit')}}">修改</a>
                        <a href="javascript::" onclick="delLinks({{$v->nav_id}})">删除</a>
                    </td>
                </tr>
                @endforeach
            </table>

        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->
<script>
    function changeOrder(obj,nav_id) {
        var nav_order = $(obj).val();

        $.post("{{url('admin/navs/changeorder')}}",{'_token':'{{csrf_token()}}','nav_id':nav_id,'nav_order':nav_order},function (data) {
            if(data.status == 0){
                layer.msg(data.msg,{icon:6});
            }else{
                layer.msg(data.msg,{icon:5});
            }
        })
    }

    //这里是删除自定义导航的提示框
    function delLinks(nav_id){
        layer.confirm('您确定要删除这个导航吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            //传异步参数
            $.post("{{url('admin/navs/')}}/"+nav_id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                if(data.status == 0){
                    //刷新当前界面
                    location.href = location.href;
                    layer.msg(data.msg,{icon: 6});
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
//            alert(cate_id);
           // layer.msg('的确很重要', {icon: 1});
        }, function(){
//            layer.msg('也可以这样', {
//                time: 20000, //20s后自动关闭
//                btn: ['明白了', '知道了']
//            });
        });
    }

</script>
@endsection