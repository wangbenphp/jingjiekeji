<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>静界科技后台管理</title>
    <link href="{{ URL::asset('/layui/css/layui.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('/css/admin/index.css')}}" rel="stylesheet" type="text/css"/>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">WIFI定位系统</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">控制台</a></li>
            <li class="layui-nav-item"><a href="">商品管理</a></li>
            <li class="layui-nav-item"><a href="">用户</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">邮件管理</a></dd>
                    <dd><a href="">消息管理</a></dd>
                    <dd><a href="">授权管理</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    admin
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="">退了</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                @foreach ($menu as $v)
                    @if ($v['is_url'] == 0)
                        <li class="layui-nav-item @if ($v['is_first'] == 1)layui-nav-itemed @endif">
                            <a class="" href="javascript:;">{{$v['name']}}</a>
                            <dl class="layui-nav-child">
                                @foreach ($v['child_list'] as $vv)
                                    <dd><a href="{{ $vv['url'] }}">{{ $vv['name'] }}</a></dd>
                                @endforeach
                            </dl>
                        </li>
                    @else
                        <li class="layui-nav-item">
                            <a href="{{ $v['url'] }}">{{ $v['name'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <div class="layui-body">