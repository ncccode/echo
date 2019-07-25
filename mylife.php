<?php
/**
 * 说说动态
 *
 * @package custom
 */
?>

<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';  //如果是文章作者的评论添加 .comment-by-author 样式
        } else {
            $commentClass .= ' comment-by-user';  //如果是评论作者的添加 .comment-by-user 样式
        }
    } 
    $commentLevelClass = $comments->_levels > 0 ? ' comment-child' : ' comment-parent';  //评论层数大于0为子级，否则是父级
?>

<div id="comment-<?php $comments->theId(); ?>" class="t-list<?php 
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-by-author');
echo $commentClass;
?>">
    <div class="t-p"><?php $comments->gravatar('40', ''); ?></div>
    <div class="t-r">
    <strong><?php $comments->author(); ?></strong>
    <p><?php $comments->content(); ?></p>
    <span><?php $comments->date('Y-m-d H:i'); ?></span>
    </div>
</div>

<?php } ?>

<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="layui-container">
    <div class="layui-row layui-col-space15 main">
        <div class="map">
            <span class="layui-breadcrumb">
                <a href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
                <?php $this->category(','); ?>
                <a><cite><?php $this->title() ?></cite></a>
            </span>
        </div>
        <div class="layui-col-md9 layui-col-lg9">
            <div class="about-life">
                <div class="t-w">
                <div class="t-u"><img height="120" src="<?php $this->options->themeUrl('img/blog.jpg'); ?>"></div>
                <div class="t-t">
                    <h1>宁采陈<span><i class="layui-icon">&#xe635;</i>全栈工程师</span></h1>
                    <div class="t-d layui-hide-xs">
                        <span class="typed"></span>
                    </div>
                    <div class="t-i">
                        <a class="layui-btn layui-btn-radius layui-btn-sm" href="/about.html"> 关于我</a>
                        <a class="layui-btn layui-btn-radius layui-btn-sm" href="/guestbook.html"> 留言</a>
                    </div>
                </div>
                </div>
            </div>
            <div class="title-life">
                <h3><i class="layui-icon">&#xe6af;</i> 我的动态</h3>
                <span> <?php $this->commentsNum('%d'); ?> 条动态，<?php get_post_view($this); ?>次观望</span>
            </div>
            <div class="mylife">
                <?php $this->comments()->to($comments); ?>
                <?php if($this->user->hasLogin()): ?>
                    <div id="<?php $this->respondId(); ?>" class="respond">
                        <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
                            <div class="layui-form-item">
                                <textarea rows="5" cols="30" name="text" id="textarea" placeholder="说点儿什么吧" class="layui-textarea" required></textarea>
                            </div>
                            <div class="layui-inline">
                                <button type="submit" class="layui-btn layui-btn-normal"><?php _e('提交评论'); ?></button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
                <br/>
                <ol class="comment-list">
                    <?php $comments->listComments(); ?>
                </ol>
            </div> 
        </div>
        
        <?php $this->need('sidebar.php'); ?>

    </div>
</div>
<script type="text/javascript" src="https://cdn.bootcss.com/typed.js/2.0.5/typed.js"></script>
<script>
    var typed = new Typed(".t-d .typed", {
        strings: ["请在mylife.php文件里修改此页信息"],
        typeSpeed:30 // 速度
    });
</script>
<style type="text/css">
    /* 如果光标没出现，而是出现在下一行，那么就是盒子是块级标签，必须得转换成行内标签 */
    .t-d p {
        display: inline;
    }
    /* 想让的光标闪动的话，复制下面的代码 */
    .typed-cursor{
        opacity: 1;
        animation: typedjsBlink 0.7s infinite;
        -webkit-animation: typedjsBlink 0.7s infinite;
        animation: typedjsBlink 0.7s infinite;
    }
    @keyframes typedjsBlink{
        50% { opacity: 0.0; }
    }
    @-webkit-keyframes typedjsBlink{
        0% { opacity: 1; }
        50% { opacity: 0.0; }
        100% { opacity: 1; }
    }
    .typed-fade-out{
        opacity: 0;
        transition: opacity .25s;
        -webkit-animation: 0;
        animation: 0;
    }
</style>
<?php $this->need('footer.php'); ?>