@include('admin.base.header')

<div style="margin-top: 25px;"></div>
<input type="hidden" id="_token" name="_token" value="{{csrf_token()}}"/>
<div class="layui-input-block" style="width: 200px; float: left; margin:0; margin-left:25px; padding: 0;">
    <input type="text" name="mac1" required  lay-verify="required" placeholder="请输入MAC地址" autocomplete="off" class="layui-input">
</div>
<div class="layui-input-block" style="width: 200px; float: left; margin:0; margin-left:25px; padding: 0;">
    <input type="text" name="mac2" required  lay-verify="required" placeholder="请输入MAC地址" autocomplete="off" class="layui-input">
</div>
<div class="layui-input-block" style="width: 200px; float: left; margin:0; margin-left:25px; padding: 0;">
    <input type="text" name="mac3" required  lay-verify="required" placeholder="请输入MAC地址" autocomplete="off" class="layui-input">
</div>
<div class="layui-input-block" style="width: 200px; float: left; margin:0; margin-left:25px; padding: 0;">
    <input type="text" name="mac4" required  lay-verify="required" placeholder="请输入MAC地址" autocomplete="off" class="layui-input">
</div>
<button class="layui-btn" style="margin-left:20px;" id="bind_tmac_show">开始追踪</button>

<div class="guiji_table" style="margin-top: 50px;">

</div>

@include('admin.base.footer')

<script>
    $('#bind_tmac_show').click(function () {
        $('.guiji_table').html('');
        var mac1 = $('input[name="mac1"]').val();
        var mac2 = $('input[name="mac2"]').val();
        var mac3 = $('input[name="mac3"]').val();
        var mac4 = $('input[name="mac4"]').val();
        var _token = $('input[name="_token"]').val();
        if (!mac1 && !mac2 && !mac3 && !mac4) {
            alert('MAC不能为空，至少为1个！');
            return false;
        }
        var timer = setInterval(function () {
            $.ajax({
                type: 'post',
                url: "/admin/getbinds",
                data: {mac1:mac1, mac2:mac2, mac3:mac3, mac4:mac4, _token:_token},
                success: function(data) {
                    if (data.code == 0) {
                        if (data.data) {
                            var str = '';
                            $.each(data.data, function(i, item) {
                                if (item.y <= 400 && item.x <= 400) {
                                    str += '<li class="zuibiaodian" style="left:' + item.x + 'px;top:' + item.y + 'px;"></li>';
                                }
                            });
                            $('.guiji_table').html(str);
                        }
                    }
                }
            });
        }, 1000)
    });
</script>