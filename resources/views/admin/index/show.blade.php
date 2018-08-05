@include('admin.base.header')

<div style="margin-top: 5px;"></div>
<input type="hidden" id="_token" name="_token" value="{{csrf_token()}}"/>
<div class="layui-input-block" style="width: 200px; float: left; margin:0; margin-left:105px; padding: 0;">
    <input type="text" name="mac" required  lay-verify="required" placeholder="请输入MAC地址" autocomplete="off" class="layui-input">
</div>
<div class="layui-input-block" style="width: 200px; float: left; margin:0; margin-left:5px; padding: 0;">
    <input type="text" name="times" required  lay-verify="required" placeholder="请输入轨迹动画运行的秒数" autocomplete="off" class="layui-input">
</div>
<div class="layui-inline" style="width: 200px; float: left; margin:0; margin-left:5px; padding: 0;"> <!-- 注意：这一层元素并不是必须的 -->
    <input type="text" name="start_time" class="layui-input" id="test1" placeholder="轨迹开始的时间">
</div>
<div class="layui-inline" style="width: 200px; float: left; margin:0; margin-left:5px; padding: 0;"> <!-- 注意：这一层元素并不是必须的 -->
    <input type="text" name="end_time" class="layui-input" id="test2" placeholder="轨迹结束的时间">
</div>
<button class="layui-btn" style="margin-left:10px;" id="selec_tmac_show">生成轨迹</button>

<div class="guiji_table" style="margin-top: 50px;">
    <div class="mubiao"></div>
</div>


@include('admin.base.footer')

<script>
    layui.use('laydate', function() {
        var laydate = layui.laydate;
        //执行一个laydate实例
        laydate.render({
            elem: '#test1', //指定元素
            type: 'datetime'
        });
        laydate.render({
            elem: '#test2', //指定元素
            type: 'datetime'
        });
    });
</script>