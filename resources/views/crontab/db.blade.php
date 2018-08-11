<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>定时任务存储DB</title>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-3.3.1.min.js') }}"></script>
</head>
<body>
<script>
    var timer = setInterval(function () {
        $.ajax({
            type: 'get',
            url: "/crontab/todb",
            data: {},
            success: function(data) {
                console.log(data);
            },
            error: function (data) {
                console.log(data);
            }
        });
    }, 1000)
</script>
</body>
</html>