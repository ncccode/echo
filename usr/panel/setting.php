<?php if(!defined('__TYPECHO_ADMIN__')) exit; ?>
<?php
$dir = __TYPECHO_ROOT_DIR__.__TYPECHO_ADMIN_DIR__;
include $dir.'common.php';
include $dir.'header.php';
include $dir.'menu.php';

Typecho_Widget::widget('Widget_Metas_Category_Admin')->to($categories);

?>

<?php echo '<link rel="stylesheet" href="'.$options->themeUrl('public/admin/css/view.css','echo').'">'; ?>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<div class="main">
    <div class="container">
        <div class="layui-card">
            <div class="layui-card-header">外观可视化设置</div>
        </div>

        <div class="layui-row layui-col-space10" id="app">
            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">设置 <button type="button" class="layui-btn layui-btn-save">保存设置</button></div>
                    <div class="layui-card-body layui-form set">

                        <div class="layui-form-item">
                            <label class="layui-form-label">网站 LOGO</label>
                            <div class="layui-input-block">
                                <input type="text" name="logoUrl" v-model="logoUrl" placeholder="网站 LOGO 地址" autocomplete="off" class="layui-input">
                                <div class="layui-word-aux">留空则不显示；在这里填入一个图片 URL 地址, 可以在网站标题前加上一个 LOGO</div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">网站 标题</label>
                            <div class="layui-input-block">
                                <input type="text" name="title" v-model="title" placeholder="网站 标题" autocomplete="off" class="layui-input">
                                <div class="layui-word-aux">留空则不显示</div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">菜单</label>
                            <div class="layui-input-block">
                            <input type="radio" lay-filter='nav' name="nav" value="0" v-model="nav" title="首页+独立页面">
                            <input type="radio" lay-filter='nav' name="nav" value="1" v-model="nav" title="首页+栏目分类" checked>
                            <input type="radio" lay-filter='nav' name="nav" value="2" v-model="nav" title="首页+独立页面+栏目分类">
                            <input type="radio" lay-filter='nav' name="nav" value="3" v-model="nav" title="首页+栏目分类+独立页面">
                            </div>
                        </div>
                        <hr>
                        <div class="layui-form-item">
                            <label class="layui-form-label">导航条悬浮</label>
                            <div class="layui-input-inline">
                                <input type="checkbox" lay-filter='navFixed' name="navFixed" value="true" v-model="navFixed" lay-skin="switch" lay-text="开启|关闭" >
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">导航条颜色</label>
                                <div class="layui-inline">
                                    <div id="headerColor"></div>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">文字颜色</label>
                                <div class="layui-inline">
                                    <div id="headerTextColor"></div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">页脚颜色</label>
                                <div class="layui-inline">
                                    <div id="footerColor"></div>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">文字颜色</label>
                                <div class="layui-inline">
                                    <div id="footerTextColor"></div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">背景颜色</label>
                                <div class="layui-inline">
                                    <div id="backgroundColor"></div>
                                </div>
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label">背景图</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="backgroundImg" v-model="backgroundImg" placeholder="背景图片链接" class="layui-input">
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">侧边栏</label>
                            <div id="sidebar"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="layui-col-md8">
                <div class="layui-card">
                    <div class="layui-card-header">视图</div>
                    <div class="layui-card-body pc">
                        <div class="body" :style="{ 'background-color': backgroundColor, 'background-image':'url('+backgroundImg+')' }">
                            <div class="layui-header header" :class="{ header_fixed: navFixed }" :style="{ 'background-color': headerColor }">
                                <div class="layui-main" style="width: 80%;">
                                    <a class="logo" href="<?php $options->siteUrl(); ?>"  :style="{ color: headerTextColor }">
                                        <img v-if="logoUrl" :src="logoUrl" :alt="title" />
                                        <template v-if="title">{{ title }}</template>
                                    </a>

                                    <ul class="layui-nav">
                                    <span>
                                        <li class="layui-nav-item layui-hide-xs layui-this">
                                            <a href="<?php $options->siteUrl(); ?>" :style="{ color: headerTextColor }"><?php _e('首页'); ?></a>
                                        </li>
                                    </span>
                                        <?php
                                            //栏目分类内容
                                            $category = '';
                                            $Category_List = Typecho_Widget::widget('Widget_Metas_Category_List');
                                            if($Category_List->have()){
                                                while($Category_List->next()){
                                                    if($Category_List->levels==0){
                                                        $category .= '<li class="layui-nav-item layui-hide-xs">'.
                                                            '<a href="'.$Category_List->permalink.'" :style="{ color: headerTextColor }">'.$Category_List->name.'</a>';

                                                            $childrens = Typecho_Widget::widget('Widget_Metas_Category_List')->getAllChildren($Category_List->mid);
                                                            if($childrens){
                                                                $category .= '<dl class="layui-nav-child">';
                                                                for ($i=0; $i <count($childrens) ; $i++) {
                                                                    $thisChild = Typecho_Widget::widget('Widget_Metas_Category_List')->getCategory($childrens[$i]);
                                                                    $category .= '<dd><a href="'.$thisChild["permalink"].'">'.$thisChild["name"].'</a></dd>';
                                                                }
                                                                $category .= '</dl>';
                                                            }
                                                        $category .= '</li>';
                                                    }
                                                }
                                            }
                                        ?>
                                        <?php
                                            //独立页面内容
                                            $page = '';
                                            $Page_List = Typecho_Widget::widget('Widget_Contents_Page_List');
                                            if($Page_List->have()){
                                                while($Page_List->next()){
                                                    $page .= '<li class="layui-nav-item layui-hide-xs">'.
                                                        '<a href="'.$Page_List->permalink.'" :style="{ color: headerTextColor }">'.$Page_List->title.'</a>'.
                                                    '</li>';
                                                }
                                            }
                                        ?>
                                        <span v-show="nav == 0"><?php echo $page; ?></span>
                                        <span v-show="nav == 1"><?php echo $category; ?></span>
                                        <span v-show="nav == 2"><?php echo $page.$category; ?></span>
                                        <span v-show="nav == 3"><?php echo $category.$page; ?></span>
                                    </ul>
                                </div>
                            </div>
                            <div class="view">
                                <div class="layui-row layui-col-space15">
                                    <div class="left">
                                        <div class="layui-panel">
                                        <div style="height: 460px;text-align: center;line-height: 460px;">文章列表</div>
                                        </div>
                                    </div>
                                    <div class="right" v-for="item in sidebar">
                                        <div class="layui-panel" v-if="item==1">
                                            <div style="padding: 15px;">搜索框</div>
                                        </div>
                                        <div class="layui-panel" v-if="item==2">
                                            <div style="padding: 15px;">栏目分类</div>
                                        </div>
                                        <div class="layui-panel" v-if="item==3">
                                            <div style="padding: 15px;">广而告之</div>
                                        </div>
                                        <div class="layui-panel" v-if="item==4">
                                            <div style="padding: 15px;">博主动态</div>
                                        </div>
                                        <div class="layui-panel" v-if="item==5">
                                            <div style="padding: 15px;">标签云</div>
                                        </div>
                                        <div class="layui-panel" v-if="item==6">
                                            <div style="padding: 15px;">友情链接</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer" :style="{ 'background-color': footerColor }">
                                <div class="layui-col-md12 t-copy">
                                    <span class="layui-breadcrumb">
                                        <span :style="{ color: footerTextColor }">&copy; <?php echo date('Y'); ?> <a href="<?php $options->siteUrl(); ?>" :style="{ color: footerTextColor +'!important' }">{{ title }}</a></span>
                                        <span :style="{ color: footerTextColor }" class="layui-hide-xs">Powered by <a href="http://typecho.org/" target="_blank" rel="nofollow" :style="{ color: footerTextColor +'!important' }">Typecho</a></span>
                                        <span :style="{ color: footerTextColor }">Theme by <a href="https://www.ncc.wang" target="_blank" :style="{ color: footerTextColor +'!important' }">Echo</a></span>
                                    </span>
                                </div>
                            </div>
                        </div>

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
    var vm = new Vue({
        el: '#app',
        data: {
            logoUrl: '<?php $options->logoUrl(); ?>',
            title: '<?php $options->title(); ?>',
            nav: '<?php $options->nav(); ?>',
            navFixed: '<?php $options->navFixed(); ?>',
            headerColor: '<?php $options->headerColor(); ?>',
            headerTextColor: '<?php $options->headerTextColor(); ?>',
            footerColor: '<?php $options->footerColor(); ?>',
            footerTextColor: '<?php $options->footerTextColor(); ?>',
            backgroundColor: '<?php $options->backgroundColor(); ?>',
            backgroundImg: '<?php $options->backgroundImg(); ?>',
            sidebar: '<?php $options->sidebar(); ?>',
        }
    })
    layui.use(["element","colorpicker","form","transfer"], function(){
        var $ = layui.$;
        var element = layui.element;
        var form = layui.form;
        var colorpicker = layui.colorpicker;
        var transfer = layui.transfer;


        form.on('radio(nav)', function(data){
            vm.$data.nav = data.value;
        });
        form.on('switch(navFixed)', function(data){
            var value = data.elem.checked?data.value:'';
            vm.$data.navFixed = value;
        });

        colorpicker.render({
            elem: '#headerColor'
            ,color: vm.$data.headerColor
            ,done: function(color){
                vm.$data.headerColor = color;
            }
        });
        colorpicker.render({
            elem: '#headerTextColor'
            ,color: vm.$data.headerTextColor
            ,done: function(color){
                vm.$data.headerTextColor = color;
            }
        });
        colorpicker.render({
            elem: '#footerColor'
            ,color: vm.$data.footerColor
            ,done: function(color){
                vm.$data.footerColor = color;
            }
        });
        colorpicker.render({
            elem: '#footerTextColor'
            ,color: vm.$data.footerTextColor
            ,done: function(color){
                vm.$data.footerTextColor = color;
            }
        });
        colorpicker.render({
            elem: '#backgroundColor'
            ,color: vm.$data.backgroundColor
            ,done: function(color){
                vm.$data.backgroundColor = color;
            }
        });


        transfer.render({
            elem: '#sidebar'
            ,title: ['可选列表', '显示列表']
            ,data: [
                {"value": "1", "title": "搜索框"}
                ,{"value": "2", "title": "栏目分类"}
                ,{"value": "3", "title": "广而告之"}
                ,{"value": "4", "title": "博主动态"}
                ,{"value": "5", "title": "标签云"}
                ,{"value": "6", "title": "友情链接"}
            ]
            ,value: [<?php $options->sidebar(); ?>]
            ,id: 'sidebar'
            ,width: 120
            ,height: 250
            ,onchange: function(data, index){
                var sidebar = [];
                var sidebarData = transfer.getData('sidebar');
                for(var key in sidebarData){
                    sidebar.push(sidebarData[key]['value']);

                }
                vm.$data.sidebar = sidebar.join();
            }
        });

        //提交
        $('.layui-btn-save').click(function(){
            var data = vm.$data;
            $.ajax({
                type: "POST",
                url: "<?php $options->index('/action/echo?do=setting'); ?>",
                data: data,
                success: function(res){
                    if(res.status == 1){
                        layer.msg(res.msg, {icon: 1});
                    }else{
                        layer.msg(res.msg, {icon: 2});
                    }
                }
            });
        });

    });
</script>
<?php include $dir.'footer.php'; ?>
