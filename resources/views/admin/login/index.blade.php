<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>静界科技后台管理</title>
    <link href="{{ URL::asset('/css/admin/login.css')}}" rel="stylesheet" type="text/css"/>
</head>

<body>
    <div class="login_box">
        <div class="login_l_img"><img src="{{ URL::asset('/image/admin/login-img.png')}}"/></div>
        <div class="login">
            <div class="login_logo"><a href="#"><img src="{{ URL::asset('/image/admin/login_logo.png')}}"/></a></div>
            <div class="login_name">
                <p>后台管理系统</p>
            </div>
            <form method="post">
                <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}"/>
                <input name="username" type="text" class="login_username" value="用户名" onfocus="this.value=''" onblur="if(this.value==''){this.value='用户名'}">
                <span id="password_text" onclick="this.style.display='none';document.getElementById('password').style.display='block';document.getElementById('password').focus().select();" >密码</span>
                <input name="password" type="password" id="password" style="display:none;" onblur="if(this.value==''){document.getElementById('password_text').style.display='block';this.style.display='none'};"/>
                <input value="登录" style="width:100%;" type="button" class="login_button">
            </form>
        </div>
        <div class="copyright">深圳静界科技有限公司 版权所有©2017-2018</div>
    </div>
    <div style="text-align:center;">
    </div>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/admin/index.js') }}"></script>
</body>
</html>
