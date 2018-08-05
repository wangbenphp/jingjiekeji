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

// $('#showsssss') .click(function () {
//     $.ajax({
//         type: 'get',
//         url: "/admin/getshow",
//         data: {},
//         success: function(data) {
//             if (data.code == 0) {
//                 if (data.data) {
//                     var style = document.styleSheets[0];
//                     $('.mubiao').css("animation",  data.data.anim + " " + data.data.time + "s");
//                     style.insertRule(data.data.values);
//                 }
//             }
//         }
//     });
// });

$('#selec_tmac_show') .click(function () {
    var mac = $('input[name="mac"]').val();
    var times = $('input[name="times"]').val();
    var start_time = $('input[name="start_time"]').val();
    var end_time = $('input[name="end_time"]').val();
    var _token = $('input[name="_token"]').val();
    if (!mac || !times) {
        alert('参数填写不完整!');
        return false;
    }
    $.ajax({
        type: 'get',
        url: "/admin/getshow",
        data: {mac:mac, times:times, start_time:start_time, end_time:end_time, _token:_token},
        success: function(data) {
            if (data.code == 0) {
                if (data.data) {
                    var style = document.styleSheets[0];
                    $('.mubiao').css("animation",  data.data.anim + " " + data.data.time + "s");
                    style.insertRule(data.data.values);
                }
            }
        },
        // error: function() {
        //     alert('请求失败')
        // }
    });
});