<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="sidebar layui-col-md3 layui-col-lg3">
    <div class="component">
        <form class="layui-form" id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
            <div class="layui-inline input">
                <input type="text" id="s" name="s" class="layui-input" required lay-verify="required" placeholder="<?php _e('输入关键字搜索'); ?>" />
            </div>
            <div class="layui-inline">
                <button class="layui-btn layui-btn-sm layui-btn-primary"><i class="layui-icon">&#xe615;</i></button>
            </div>
        </form>
    </div>
    <div class="column">
        <h3 class="title-sidebar"><i class="layui-icon">&#xe705;</i> <?php _e('栏目分类'); ?></h3>
        <ul class="layui-row layui-col-space5">
            <?php $this->widget('Widget_Metas_Category_List')
               ->parse('<li class="layui-col-md12 layui-col-xs6"><a href="{permalink}"><i class="layui-icon">&#xe63c;</i> {name}<span class="layui-badge layui-bg-gray">{count}</span></a></li>'); ?>
        </ul>
    </div>
    <div class="tags">
            <h3 class="title-sidebar"><i class="layui-icon">&#xe66e;</i>标签云</h3>
            <div>
                <?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=30')->to($tags); ?>
                <?php while($tags->next()): ?>
                    <a class="layui-btn layui-btn-xs layui-btn-primary" style="color: rgb(<?php echo(rand(0, 255)); ?>, <?php echo(rand(0,255)); ?>, <?php echo(rand(0, 255)); ?>)" href="<?php $tags->permalink(); ?>" title='<?php $tags->name(); ?>'><?php $tags->name(); ?></a>
                <?php endwhile; ?>
            </div>
    </div>
</div>