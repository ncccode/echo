layui.use('element', function(){
    var $ = layui.$,
    element = layui.element;
    $(".nav-btn").on('click', function(){
        $('.nav-btn dl').toggleClass('layui-show');
    });
});