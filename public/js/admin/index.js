$('.login_button').click(function () {
    var username = $('.login_username').val();
    var password = $('#password').val();
    var _token = $('#_token').val();
    $.ajax({
        url: '/admin/logindata',
        type: 'POST',
        data: {_token: _token, username: username, password: password},
        dataType: 'json',
        success: function (data) {
            if (data.code == 0) {
                //window.location.href = "/admin/index";
                //$(window).attr('location', '/admin/index');
                alert(666);
            } else {
                alert(data.message);
            }
        },
        error: function() {
            console.log('请求失败')
        }
    });
});