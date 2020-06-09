<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php if (!empty($this->options->sidebar)): ?>
    <?php $sidebar = explode(",",$this->options->sidebar);?>
    <?php if (in_array("1",$sidebar)): ?>
        <div class="component layui-show-xs-block layui-hide-sm" style="margin: 0px 7.5px;">
            <form class="layui-form" id="search" method="post" action="{$this->options->siteUrl}" role="search">
                <div class="layui-inline input">
                    <input type="text" id="s" name="s" class="layui-input" required lay-verify="required" placeholder="输入关键字搜索" />
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layui-btn-sm layui-btn-primary"><i class="layui-icon">&#xe615;</i></button>
                </div>
            </form>
        </div>
    <?php endif; ?>
<?php endif; ?>