<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="layui-container">
    <div class="layui-row layui-col-space15 main">
        <div class="map">
            <span class="layui-breadcrumb">
                <a href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
                <?php $this->category(','); ?>
                <a><cite>正文</cite></a>
            </span>
        </div>
        <div class="layui-col-md9 layui-col-lg9">
            <div class="title-article">
                <h1><?php $this->title() ?></h1>
                <div class="title-msg">
                    <span><i class="layui-icon">&#xe612;</i> <?php $this->author(); ?></span>
                    <span><i class="layui-icon">&#xe60e;</i> <?php $this->date('Y-m-d A'); ?> </span>
                    <span><i class="layui-icon">&#xe62c;</i> <?php get_post_view($this); ?>℃</span>
                    <span><i class="layui-icon">&#xe63a;</i> <?php $this->commentsNum('%d'); ?>条</span>
                </div>
            </div>
            <div class="text" itemprop="articleBody">
                <?php $this->content(); ?>
            </div>
            <div class="tags-text">
                <i class="layui-icon">&#xe66e;</i><?php _e('标签: '); ?><?php $this->tags(', ', true, 'none'); ?>
            </div>
            <div class="copy-text">
                <div>
                    <p>非特殊说明，本博所有文章均为博主原创。</p>
                    <p class="hidden-xs">如若转载，请注明出处：<a href="<?php $this->permalink() ?>"><?php $this->permalink() ?></a> </p>
                </div>
            </div>
            <div class="page-text">
                <div>
                    <span class="layui-badge layui-bg-gray">上一篇</span>
                    <?php $this->thePrev('%s','没有了'); ?>
                </div>
                <div>
                    <span class="layui-badge layui-bg-gray">下一篇</span>
                    <?php $this->theNext('%s','没有了'); ?>
                </div>
            </div>
            <div class="comment-text layui-form">
                <?php $this->need('comments.php'); ?>
            </div>
        </div>
        
        <?php $this->need('sidebar.php'); ?>

    </div>
</div>

<?php $this->need('footer.php'); ?>
