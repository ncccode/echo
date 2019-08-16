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
    <div class="dynamic">
        <h3 class="title-sidebar"><i class="layui-icon">&#xe60c;</i>博主动态 ~ </h3>
        <ul>
            <?php
                $db = Typecho_Db::get();
                $cid = $db->fetchRow($db->select('cid')->from('table.contents')->where('template = ? AND status = ?', 'mylife.php', 'publish'))['cid'];
                $comments = $db->fetchAll($db->select()->from('table.comments')->where('cid = ? AND status = ?', $cid, 'approved')->order('created', Typecho_Db::SORT_DESC));
                
                foreach($comments as $comment) {
                    echo '<li>';
                    echo '<span class="layui-badge-dot layui-bg-gray"></span>';
                    echo '<p>'.$comment['text'].'<small>'.date("Y年m月d日 H:i:s",$comment['created']).'</small></p>';
                    echo '</li>';
                }
            ?>          
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
    <div class="link">
        <h3 class="title-sidebar"><i class="layui-icon">&#xe64c;</i>友情链接<a style="float: right;color: #666;" href="#">申请</a></h3>
        <div>
            <a class="layui-btn layui-btn-xs layui-btn-primary" href="https://www.echo.so" title='宁采陈个人博客0' target="_blank">宁采陈博客0</a>
            <a class="layui-btn layui-btn-xs layui-btn-primary" href="https://www.echo.so" title='宁采陈个人博客1' target="_blank">宁采陈博客1</a>
            <a class="layui-btn layui-btn-xs layui-btn-primary" href="https://www.echo.so" title='宁采陈个人博客2' target="_blank">宁采陈博客2</a>
        </div>
    </div>
</div>