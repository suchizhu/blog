layui.use(['element', 'layedit', 'laypage', 'form', 'upload', 'util'], function () {
    var element = layui.element
        , $ = layui.$
        , layedit = layui.layedit
        , laypage = layui.laypage
        , form = layui.form
        , layer = layui.layer
        , upload = layui.upload
        , util = layui.util;

    var index = layedit.build('editor');

    util.fixbar();

    laypage.render({
        elem: 'page'
        , count: $('#page').attr('lay-count')
        , limit: $('#page').attr('lay-limit')
        , curr: $('#page').attr('lay-curr')
        , jump: function (obj, first) {
            if (!first) {
                if(location.href.indexOf('type_id') != -1){
                    location.href = $("#page").attr('lay-url') + '&page=' + obj.curr;
                }else{
                    location.href = $("#page").attr('lay-url') + '?page=' + obj.curr;
                }
            }
        }
    });

    laypage.render({
        elem: 'comment-page'
        , count: $('#comment-page').attr('lay-count')
        , limit: $('#comment-page').attr('lay-limit')
        , curr: $('#comment-page').attr('lay-curr')
        , jump: function (obj, first) {
            if (!first) {
                location.href = $("#comment-page").attr('lay-url') + '&page=' + obj.curr;
            }
        }
    });

    form.on('submit(comment)',function(data){
        var content = layedit.getContent(index);
        $.ajax({
            url: $(data.form).attr('action')
            ,type: 'post'
            ,data: {content: content,article_id: data.field.article_id}
            ,success: function (res) {
                if(res.code == 2){
                    layer.msg(res.msg, {time: 1000, shade: 0.1},function(){
                        location.href = res.data;
                    });
                }else if(res.code == 1){
                    layer.msg(res.msg,{icon: 5,time: 1000, shade: 0.1});
                }else {
                    layer.msg(res.msg,{icon: 6,time: 1000, shade: 0.1},function(){
                        var tpl = [
                            '<li>',
                                '<div class="layui-user-avatar">',
                                    '<img src="'+res.data.src+'" alt="'+res.data.nickname+'">',
                                '</div>',
                                '<div class="layui-user-info">',
                                    '<span>'+res.data.nickname+'</span><br>',
                                    '<span>'+res.data.time+'</span>',
                                '</div>',
                                '<div class="layui-user-comment">',
                                    content,
                                '</div>',
                            '</li>'
                        ].join('');
                        $('.layui-user').append(tpl);
                    });
                }
            }
        });
        return false;
    });

    form.on('submit(login)',function(data){
        $.ajax({
            url: $(data.form).attr('action')
            ,type: 'post'
            ,data: data.field
            ,success: function (res) {
                if(res.code == 0){
                    layer.msg(res.msg,{icon: 6,time: 1000,shade: 0.1},function () {
                        location.href = res.data;
                    });
                }else{
                    layer.msg(res.msg,{icon: 5,time: 1000,shade: 0.1});
                }
            }
        });
        return false;
    });

    form.on('submit(userinfo)',function(data){
        $.ajax({
            url: $(data.form).attr('action')
            ,type: 'post'
            ,data: data.field
            ,success: function (res) {
                if(res.code == 0){
                    layer.msg(res.msg,{icon: 6,time: 1000,shade: 0.1});
                }else{
                    layer.msg(res.msg,{icon: 5,time: 1000,shade: 0.1});
                }
            }
        });
        return false;
    });

    form.on('submit(password)',function(data){
        $.ajax({
            url: $(data.form).attr('action')
            ,type: 'post'
            ,data: data.field
            ,success: function (res) {
                if(res.code == 0){
                    layer.msg(res.msg,{icon: 6,time: 1000,shade: 0.1},function () {
                        location.href = res.data;
                    });
                }else{
                    layer.msg(res.msg,{icon: 5,time: 1000,shade: 0.1});
                }
            }
        });
        return false;
    });

    form.on('submit(register)',function(data){
        $.ajax({
            url: $(data.form).attr('action')
            ,type: 'post'
            ,data: data.field
            ,success: function (res) {
                if(res.code == 0){
                    layer.msg(res.msg,{icon: 6,time: 1000,shade: 0.1},function () {
                        location.href = res.data;
                    });
                }else{
                    layer.msg(res.msg,{icon: 5,time: 1000,shade: 0.1});
                }
            }
        });
        return false;
    });

    upload.render({
        elem: '#imageUpload'
        , url: '/api/common/uploadAvatar'
        , data: {image_id: $("#image_id").val(), path: $("#avatar_src").attr('src')}
        , field: 'image'
        , size: 50
        , done: function (res) {
            if (res.code == 0) {
                layer.msg(res.msg, {icon: 6, time: 1000, shade: 0.1}, function () {
                    $("#avatar_src").attr('src', res.data);
                });
            }
        }
    });

    // 点击更换验证码
    $(".layui-admin-vercode").on('click', function () {
        $(this).attr('src', '/admin/index/captcha');
    });
});