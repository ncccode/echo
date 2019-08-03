<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php function threadedComments($comments, $options) {
    $commentClass = '';$group = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $group = '博主';
            $commentClass .= ' comment-by-author';  //如果是文章作者的评论添加 .comment-by-author 样式
        } else {
            $group = '';
            $commentClass .= ' comment-by-user';  //如果是评论作者的添加 .comment-by-user 样式
        }
    } 
    $commentLevelClass = $comments->_levels > 0 ? ' comment-child' : ' comment-parent';  //评论层数大于0为子级，否则是父级
?>

<li id="li-<?php $comments->theId(); ?>" class="comment-body<?php 
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass;
?>">
    <div id="<?php $comments->theId(); ?>" class="pl-dan comment-txt-box">
        <div class="t-p comment-author">
            <?php $comments->gravatar('40', ''); ?>
        </div>
        <div class="t-u comment-author">
            <strong>
                <?php $comments->author(); ?>
                <span class="layui-badge"><?php echo $group; ?></span>
            </strong>
            <div><b><?php echo getPermalinkFromCoid($comments->parent); ?></b></div>
            <div class="t-s"><p><?php $comments->content(); ?></p></div>
            <span class="t-btn"><?php $comments->reply(); ?> <span class="t-g"><?php $comments->date('Y-m-d H:i'); ?></span></span> 
        </div><!-- 单条评论者信息及内容 -->
    </div>
    <?php if ($comments->children) { ?>
        <div class="pl-list comment-children">
            <?php $comments->threadedComments($options); ?>
        </div>
    <?php } ?>
</li>

<?php } ?>



<div id="comments">
    <?php $this->comments()->to($comments); ?>
    
    <?php if($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>" class="respond">
            <div class="cancel-comment-reply">
                <?php $comments->cancelReply(); ?>
            </div>
        
            <h4 id="response"><i class="layui-icon">&#xe664;</i> <?php _e('评论啦~'); ?></h4>
            <br/>
            <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
                <?php if($this->user->hasLogin()): ?>
                <div class="layui-form-item">
                    <div class="layui-form-mid layui-word-aux">
                        <?php _e('登录身份: '); ?>
                        <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>
                        <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a>
                    </div>
                </div>
                <div class="layui-form-item">
                    <textarea rows="5" cols="30" name="text" id="textarea" placeholder="嘿~ 大神，别默默的看了，快来点评一下吧" class="layui-textarea" required></textarea>
                </div>
                <?php else: ?>
                <div class="layui-form-item">
                    <textarea rows="5" cols="30" name="text" id="textarea" placeholder="嘿~ 大神，别默默的看了，快来点评一下吧" class="layui-textarea" required></textarea>
                </div>
                <div class="layui-form-item layui-row layui-col-space5">
                    <div class="layui-col-md4">
                        <input type="text" name="author" id="author" class="layui-input" placeholder="* 怎么称呼" value="<?php $this->remember('author'); ?>" required />
                    </div>
                    <div class="layui-col-md4">
                        <input type="email" name="mail" id="mail" lay-verify="email" class="layui-input" placeholder="<?php if ($this->options->commentsRequireMail): ?>* <?php endif; ?>邮箱(放心~会保密~.~)" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail): ?>required<?php endif; ?> />
                    </div>
                    <div class="layui-col-md4">
                        <input type="url" name="url" id="url" lay-verify="url" class="layui-input" placeholder="<?php if ($this->options->commentsRequireURL): ?>* <?php endif; ?><?php _e('http://您的主页'); ?>" value="<?php $this->remember('url'); ?>" <?php if ($this->options->commentsRequireURL): ?>required<?php endif; ?> />
                    </div>
                </div>
                <?php endif; ?>
                <div class="layui-inline">
                    <button type="submit" class="layui-btn layui-btn-normal"><?php _e('提交评论'); ?></button>
                </div>
            </form>
        </div>
        <?php if ($comments->have()): ?>
            <br/>
            <h3><?php $this->commentsNum(_t('暂无评论'), _t('唉呀 ~ 仅有一条评论'), _t('已有 %d 条评论')); ?></h3>
            <br/>
            <div class="pinglun">
                <?php $comments->listComments(); ?>
            </div>
            <div class="page-navigator">
                <?php $comments->pageNav('«', '»', 1, '...', array('wrapTag' => 'div', 'wrapClass' => 'layui-laypage layui-laypage-molv', 'itemTag' => '', 'currentClass' => 'current', )); ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <h3><?php _e('评论已关闭'); ?></h3>
    <?php endif; ?>
</div>
