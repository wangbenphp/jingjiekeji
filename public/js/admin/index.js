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
                window.location.href = "/admin/index";
            } else {
                alert(data.message);
            }
        },
        error: function() {
            console.log('请求失败')
        }
    });
});

$('#showsssss') .click(function () {
    $.ajax({
        type: 'get',
        url: "/admin/getshow",
        data: {},
        success: function(data) {
            if (data.code == 0) {
                if (data.data) {
                    var style = document.styleSheets[0];
                    $('.mubiao').css("animation",  data.data.anim + " " + data.data.time + "s");
                    style.insertRule(data.data.values);
                }
            }
        }
    });
});