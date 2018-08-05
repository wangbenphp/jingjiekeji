@include('admin.base.header')

    <div class="guiji_table">

    </div>

<script>
    var timer = setInterval(function () {
        $.ajax({
            type: 'get',
            url: "/admin/getcoordinate",
            data: {},
            success: function(data) {
                if (data.code == 0) {
                    if (data.data) {
                        var str = '';
                        $.each(data.data, function(i, item) {
                            if (item.y <= 400 && item.x <= 400) {
                                str += '<li class="zuibiaodian" style="left:' + item.x + 'px;top:' + item.y + 'px;"></li>';
                            }
                        });
                        $('.guiji_table').html('');
                        $('.guiji_table').html(str);
                    }
                }
            }
        });
    }, 1000)
</script>
@include('admin.base.footer')