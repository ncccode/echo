$(function(){
    //添加结构
    $('#typecho-nav-list').prepend(
        '<div class="echo-logo"> <span>Echo Theme</span> </div>'
    );
    //添加图标
    $('#typecho-nav-list .root .parent').each(function(i){
        switch ($(this).text()) {
            case '控制台':
                $(this).html('<a href="javascript:;" lay-tips="控制台"><i class="layui-icon layui-icon-home"></i><cite>控制台</cite><span class="layui-nav-more"></span></a>');
                break;
            case '撰写':
                $(this).html('<a href="javascript:;" lay-tips="撰写"><i class="layui-icon layui-icon-read"></i><cite>撰写</cite><span class="layui-nav-more"></span></a>');
                break;
            case '管理':
                $(this).html('<a href="javascript:;" lay-tips="管理"><i class="layui-icon layui-icon-component"></i><cite>管理</cite><span class="layui-nav-more"></span></a>');
                break;
            case '设置':
                $(this).html('<a href="javascript:;" lay-tips="设置"><i class="layui-icon layui-icon-set"></i><cite>设置</cite><span class="layui-nav-more"></span></a>');
                break;
            case 'Echo':
                $(this).html('<a href="javascript:;" lay-tips="Echo"><i class="layui-icon layui-icon-theme"></i><cite>Echo</cite><span class="layui-nav-more"></span></a>');
                break;
            default:
                $(this).html('<a href="javascript:;" lay-tips="'+$(this).text()+'"><i class="layui-icon layui-icon-app"></i><cite>'+$(this).text()+'</cite><span class="layui-nav-more"></span></a>');

        }
    });
    //菜单折叠
    $('#typecho-nav-list .root .parent').click(function(){
        if($('body').hasClass('side-shrink')){
            events.flexible();
        }else{
            $(this).parent().toggleClass("focus");
        }
    })


    //添加结构
    $('.typecho-head-nav .operate').prepend(
        '<div class="nav-left">'+
            '<a href="javascript:;" echo-event="flexible" title="侧边伸缩">'+
                '<i class="layui-icon layui-icon-shrink-right" id="app_flexible"></i>'+
            '</a>'+
            '<a href="javascript:;" echo-event="fullscreen" class="layui-hide-xs">'+
                '<i class="layui-icon layui-icon-screen-full"></i>'+
            '</a>'+
            '<a href="javascript:location.reload();" title="刷新">'+
                '<i class="layui-icon layui-icon-refresh-3"></i>'+
            '</a>'+
        '</div>'
    );

    //移动端自动收缩
    if($(window).width() < 992) events.flexible();

    //删除底部信息
    $('.typecho-foot').remove();


});

layui.use(['layer'], function(){
    var layer = layui.layer;

    //注册点击事件
    $('body').on('click', '*[echo-event]', function(){
        var othis = $(this)
        ,attrEvent = othis.attr('echo-event');
        events[attrEvent] && events[attrEvent].call(this, othis);
    });

    //tips
    $('body').on('mouseenter', '*[lay-tips]', function(){
        var othis = $(this);

        if(othis.parent().hasClass('parent') && !$('body').hasClass('side-shrink')) return;

        var tips = othis.attr('lay-tips');console.log($('body').hasClass('side-shrink'));
        index = layer.tips(tips, this, {tips: 2,time: -1});
        othis.data('index', index);
    }).on('mouseleave', '*[lay-tips]', function(){
        layer.close($(this).data('index'));
    });

});

//事件
var events = {
    //伸缩
    flexible: function(othis){

        var app = $('body')
        ,iconElem =  $('#app_flexible')
        ,isSpread = iconElem.hasClass('layui-icon-spread-left')
        ,width = $(window).width();

        //设置状态，PC：默认展开、移动：默认收缩
        if(isSpread){
            //切换到展开状态的 icon，箭头：←
            iconElem.removeClass('layui-icon-spread-left').addClass('layui-icon-shrink-right');

            //移动：从左到右位移；PC：清除多余选择器恢复默认
            if(width < 992){
                app.addClass('side-spread-sm');
            } else {
                app.removeClass('side-spread-sm');
            }

            app.removeClass('side-shrink')
        } else {
            //切换到收缩状态的 icon，箭头：→
            iconElem.removeClass('layui-icon-shrink-right').addClass('layui-icon-spread-left');

            //移动：清除多余选择器恢复默认；PC：从右往左收缩
            if(width < 992){
                app.removeClass('side-shrink');
            } else {
                app.addClass('side-shrink');
            }

            app.removeClass('side-spread-sm')
        }
    },

    //全屏
    fullscreen: function(othis){
        var SCREEN_FULL = 'layui-icon-screen-full'
        ,SCREEN_REST = 'layui-icon-screen-restore'
        ,iconElem = othis.children("i");

        if(iconElem.hasClass(SCREEN_FULL)){
            var ele = document.documentElement
            ,reqFullScreen = ele.requestFullScreen || ele.webkitRequestFullScreen
            || ele.mozRequestFullScreen || ele.msRequestFullscreen;
            if(typeof reqFullScreen !== 'undefined' && reqFullScreen) {
              reqFullScreen.call(ele);
            };
            iconElem.addClass(SCREEN_REST).removeClass(SCREEN_FULL);
        } else {
            var ele = document.documentElement
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
                document.webkitCancelFullScreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
            iconElem.addClass(SCREEN_FULL).removeClass(SCREEN_REST);
        }
    },
}
