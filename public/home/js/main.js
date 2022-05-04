layui.use(['layer', 'element', 'util'], function(){
    var $ = layui.$,
    layer = layui.layer,
    element = layui.element,
    util = layui.util;

    $(".nav-btn").on('click', function(){
        $('.nav-btn dl').toggleClass('layui-show');
    });

    //友情链接tips
    $(".link div a").mouseover(function(e) {
        if ($.trim(this.title) != '') {
            this.Title = this.title;
            this.title = "";
            layer.tips(this.Title, this, {tips: 3});
        }
    }).mouseout(function() {
        if (this.Title != null) {
            this.title = this.Title;
        }
    })

    //文章图片点击事件(如果为pc端才生效)
    // var device = layui.device();
    // if(!(device.weixin || device.android || device.ios)){
    //     $(".text img").click(function() {
    //         $.previewImage(this.src);
    //     });
    //     $.previewImage = function (src) {
    //         var img = new Image(), index = layer.load(2, {time: 0, scrollbar: false, shade: [0.02, '#000']});
    //         img.style.background = '#fff', img.style.display = 'none';
    //         img.src = src;
    //         document.body.appendChild(img), img.onerror = function () {
    //             layer.close(index);
    //         }, img.onload = function () {
    //             layer.open({
    //                 type: 1, shadeClose: true, success: img.onerror, content: $(img), title: false,
    //                 area: [img.width > 1140 ? '1140px' : img.width, img.height > 800 ? '800px' : img.height], closeBtn: 1, skin: 'layui-layer-nobg', end: function () {
    //                     document.body.removeChild(img);
    //                 }
    //             });
    //         };
    //     };
    // }

    //更换为fancybox 2022-05-04
    $('#preview img').each(function () {
        $(this).wrap($(`<a style="display: block;" data-fancybox="images" href="${$(this).attr('src')}"></a>`));
    });

    //右下角工具箱（返回顶部）
    var dark = localStorage.getItem("dark");
    if(dark==1){
        $("body").addClass("dark");
    }
    util.fixbar({
        bar1: '&#xe748;'
        ,click: function(type){
            if(type === 'bar1'){
                var dark = localStorage.getItem("dark");
                console.log(dark);
                if(dark==1){
                    localStorage.removeItem("dark");
                    $("body").removeClass("dark");
                }else{
                    localStorage.setItem("dark", "1");
                    $("body").addClass("dark");
                }
            }
        }
    });

});
