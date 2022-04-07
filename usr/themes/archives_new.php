<?php
/**
 * (新)文章归档
 *
 * @package custom
 */
?>

<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('common/header.php'); ?>


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
            <div class="archives">
                <div class="title-page">
                    <h3><i class="layui-icon">&#xe653;</i> 文章归档</h3>
                    <p><?php $stat = Typecho_Widget::widget('Widget_Stat'); _e('目前共计 <em>%s</em> 篇日志，共 <em>%s</em> 条评论，加油啊~',$stat->PublishedPostsNum, $stat->PublishedCommentsNum); ?></p>
                </div>
                <ul class="layui-timeline" id="timeline">
                    <?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y 年 m 月')->to($archives); ?>
                    <?php while($archives->next()): ?>
                        <li class="timeline-header">
                            <span class="layui-btn layui-btn-radius layui-btn-primary">
                                <a href="<?php $archives->permalink(); ?>"><h2 id="timeline-header-<?php $archives->sequence(); ?>"><?php $archives->date(); ?></h2></a>
                            </span>
                        </li>

                        <?php
                            $year = $archives->year;
                            $month = $archives->month;
                            $nextYear = $month == 12 ? $year+ 1 : $year;
                            $nextMonth = $month == 12 ? 1 : $month+1;
                            $contents = $this->db->fetchAll($this->select()
                            ->where('table.contents.status = ?', 'publish')
                            ->where('table.contents.created >= ?', strtotime("$year-$month"))
                            ->where('table.contents.created < ?', strtotime("$nextYear-$nextMonth"))
                            ->where('table.contents.type = ?', 'post')
                            ->order('table.contents.created', Typecho_Db::SORT_DESC), array($this, 'push'));
                            //var_dump($contents);
                            foreach ($contents as $content) {
                                $html = <<<HTML
                                <li class="timeline-item">
                                    <div class="timeline-wrap">
                                        <span class="timeline-date">{$content['day']} 日</span>
                                        <span class="timeline-content">
                                            <a href="{$content['permalink']}" class="timeline-text">{$content['title']}</a>
                                        </span>
                                    </div>
                                </li>
HTML;

                                echo $html;
                            }
                        ?>
                    <?php endwhile; ?>
                    <li class="timeline-header">
                        <div class="layui-btn layui-btn-radius layui-btn-primary"><a href="#" class="timeline-text">破壳日</a></div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="sidebar layui-col-md3 layui-col-lg3">
            <div class="timeline-menu">
                <h3 class="title-sidebar"><i class="layui-icon">&#xe60c;</i>目录</h3>
                <ul class="timeline-menu-list">
                    <?php while($archives->next()): ?>
                        <li id="anchor-timeline-header-<?php $archives->sequence(); ?>" class="timeline-menu-item">
                            <a class="timeline-menu-anchor" href="#timeline-header-<?php $archives->sequence(); ?>"><?php $archives->date(); ?></a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>

    </div>
</div>
<script src="<?php $this->options->themeUrl('layui/lay/modules/jquery.js'); ?>"></script>
<script type="text/javascript">
layui.use('jquery', function(){
    var $ = layui.$;
    $(function(){
        $(".timeline-menu").width($('.timeline-menu').width());
        $(window).scroll(function(){scrollShow();})
        function scrollShow()
        {
            for (var i = <?php $archives->length(); ?>; i > 0; i--) {
                var id  = 'timeline-header-'+i;
                var anchor  = '#anchor-timeline-header-'+i;
                var header = document.getElementById(id);
                var top = header.offsetTop;
                if (window.scrollY > top -1 ) {
                    $(anchor).addClass('active').siblings().removeClass('active');
                    break;
                }
            }
            var timeline = document.getElementById('timeline').offsetTop;
            if (window.scrollY > timeline -1 ) {
                $('.timeline-menu').addClass('timeline-menu-fixed');
            }else{
                $('.timeline-menu').removeClass('timeline-menu-fixed');
            }
        }
    });
});
</script>

<?php $this->need('common/footer.php'); ?>
