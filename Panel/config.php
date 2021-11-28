<?php if(!defined('__TYPECHO_ADMIN__')) exit; ?>
<?php
$dir = __TYPECHO_ROOT_DIR__.__TYPECHO_ADMIN_DIR__;
include $dir.'common.php';
include $dir.'header.php';
include $dir.'menu.php';

?>

<div class="main">
    <div class="container">
        <div class="layui-row layui-col-space10" id="app">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">设置</div>
                    <div class="layui-card-body layui-form">

                        <div class="layui-form-item">
                            <label class="layui-form-label">代码高亮<br/>样式风格</label>
                            <div class="layui-input-block">
                                <input type="radio" lay-filter='codeStyle' name="codeStyle" <?php if($options->codeStyle==0){echo 'checked';} ?> value="0" title="灰色">
                                <input type="radio" lay-filter='codeStyle' name="codeStyle" <?php if($options->codeStyle==1){echo 'checked';} ?> value="1" title="黑色">
                            </div>
                        </div>
                        <hr>

                        <div class="layui-form-item">
                            <label class="layui-form-label">gravatar地址</label>
                            <div class="layui-input-inline" style="width: 250px;">
                                <input type="text" name="gravatar" value="<?php $options->gravatar(); ?>" placeholder="gravatar头像地址" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">例如：http://gravatar.echo.so/avatar/</div>
                        </div>
                        <hr>

                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">首页大横幅</label>
                                <div class="layui-input-inline" style="width: 80px;">
                                    <input type="checkbox" lay-filter='bigCarouselSwitch' name="bigCarouselSwitch" value="true" <?php if($options->bigCarouselText){echo 'checked';} ?> lay-skin="switch" lay-text="开启|关闭" >
                                </div>
                                <label class="layui-form-label">高度</label>
                                <div class="layui-input-inline" style="width: 140px;">
                                    <input type="text" name="bigCarouselHeight" value="<?php $options->bigCarouselHeight(); ?>" placeholder="设定轮播容器宽度" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid">支持像素和百分比，如：180px</div>
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">大横幅内容</label>
                            <div class="layui-input-block">
                                <textarea name="bigCarouselText" placeholder='请输入轮播内容,例如&#13;&#10;<img src="xxx.jpg" />&#13;&#10;<a href="xxx"><img src="xxx" /></a>' class="layui-textarea"><?php $options->bigCarouselText(); ?></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">首页小横幅</label>
                                <div class="layui-input-inline" style="width: 80px;">
                                    <input type="checkbox" lay-filter='smallCarouselSwitch' name="smallCarouselSwitch" value="true" <?php if($options->smallCarouselSwitch){echo 'checked';} ?> lay-skin="switch" lay-text="开启|关闭" >
                                </div>
                                <label class="layui-form-label">高度</label>
                                <div class="layui-input-inline" style="width: 140px;">
                                    <input type="text" name="smallCarouselHeight" value="<?php $options->smallCarouselHeight(); ?>" placeholder="设定轮播容器宽度" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid">支持像素和百分比，如：180px</div>
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">小横幅内容</label>
                            <div class="layui-input-block">
                                <textarea name="smallCarouselText" placeholder='请输入轮播内容,例如&#13;&#10;<img src="xxx.jpg" />&#13;&#10;<a href="xxx"><img src="xxx" /></a>' class="layui-textarea"><?php $options->smallCarouselText(); ?></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="layui-form-item">
                            <label class="layui-form-label">文章首页<br/>缩略图方式</label>
                            <div class="layui-input-block">
                                <input type="radio" lay-filter='thumbType' name="thumbType" <?php if($options->thumbType==0){echo 'checked';} ?> value="0" title="不显示">
                                <input type="radio" lay-filter='thumbType' name="thumbType" <?php if($options->thumbType==1){echo 'checked';} ?> value="1" title="取附件首图">
                                <input type="radio" lay-filter='thumbType' name="thumbType" <?php if($options->thumbType==2){echo 'checked';} ?> value="2" title="取文章首图">
                                <input type="radio" lay-filter='thumbType' name="thumbType" <?php if($options->thumbType==3){echo 'checked';} ?> value="3" title="自定义随机">
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">自定义随机图片</label>
                            <div class="layui-input-block">
                                <textarea name="thumbs" placeholder='首页文章列表缩略图，自定义图片链接&#13;&#10;可固定一张，多张随机使用|分割&#13;&#10;例如&#13;&#10;https://www.xxx.com/xxx.jpg|&#13;&#10;https://www.xxx.com/xxx.jpg' class="layui-textarea"><?php $options->thumbs(); ?></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">广而告之</label>
                            <div class="layui-inline">
                                <label class="layui-form-label">文字</label>
                                <div class="layui-input-inline" style="width: 80px;">
                                    <input type="text" name="adsText" value="<?php $options->adsText(); ?>" placeholder="标题文字" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-input-block">
                                <textarea name="ads" placeholder='友情链接,例如:&#13;&#10;<a href="https://www.ncc.wang" title="描述" target="_blank"><img src="xxx.png" alt="描述"></a>' class="layui-textarea"><?php $options->ads(); ?></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">友情链接</label>
                            <div class="layui-inline">
                                <label class="layui-form-label">申请文字</label>
                                <div class="layui-input-inline" style="width: 80px;">
                                    <input type="text" name="linksText" value="<?php $options->linksText(); ?>" placeholder="申请文字" autocomplete="off" class="layui-input">
                                </div>
                                <label class="layui-form-label">申请地址</label>
                                <div class="layui-input-inline" style="width: 140px;">
                                    <input type="text" name="linksUrl" value="<?php $options->linksUrl(); ?>" placeholder="添加友情链接申请地址" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-input-block">
                                <textarea name="links"  placeholder='友情链接,例如:&#13;&#10;<a href="https://www.ncc.wang" title="描述" target="_blank">名称</a>&#13;&#10;<a href="https://www.ncc.wang" title="描述" target="_blank">名称</a>' class="layui-textarea"><?php $options->links(); ?></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">博主动态：</label>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">昵称</label>
                                <div class="layui-input-inline" style="width: 80px;">
                                    <input type="text" name="mylifeName" value="<?php $options->mylifeName(); ?>" placeholder="昵称" autocomplete="off" class="layui-input">
                                </div>
                                <label class="layui-form-label">职业</label>
                                <div class="layui-input-inline" style="width: 80px;">
                                    <input type="text" name="mylifeJob" value="<?php $options->mylifeJob(); ?>" placeholder="职业" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">头像地址</label>
                            <div class="layui-input-block">
                                <input type="text" name="mylifeAvatar" value="<?php $options->mylifeAvatar(); ?>" placeholder="头像图片链接" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">简介描述</label>
                            <div class="layui-input-block">
                                <input type="text" name="mylifeDesc" value="<?php $options->mylifeDesc(); ?>" placeholder="一句话简介" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">按钮组</label>
                            <div class="layui-input-block">
                                <textarea name="mylifeBtn" placeholder='按钮组,例如:&#13;&#10;<a href="/about.html"> 关于我</a>' class="layui-textarea"><?php $options->mylifeBtn(); ?></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">脚本代码</label>
                            <div class="layui-input-block">
                                <textarea name="script" placeholder='可以放置js脚本代码之类,例如网站统计js：&#13;&#10;<div style="display:none">&#13;&#10;    <script type="text/javascript" src="xxx"></script>&#13;&#10;</div>' class="layui-textarea"><?php $options->script(); ?></textarea>
                            </div>
                        </div>
                        <button type="button" class="layui-btn layui-btn-save" lay-submit lay-filter="*">保存设置</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<?php
include $dir.'common-js.php';
?>

<script>
    layui.use(["element","form"], function(){
        var $ = layui.$;
        var element = layui.element;
        var form = layui.form;

        //提交
        form.on('submit(*)', function(data){
            $.ajax({
                type: "POST",
                url: "<?php $options->index('/action/echo?do=config'); ?>",
                data: data.field,
                success: function(res){
                    if(res.status == 1){
                        layer.msg(res.msg, {icon: 1});
                    }else{
                        layer.msg(res.msg, {icon: 2});
                    }
                }
            });
            return false;
        });

    });
</script>
<?php include $dir.'footer.php'; ?>
