<?php
/**
 * 念念不忘　　必有回响
 * 每一处地方的精心打磨
 * 都只为离完美更进一步
 *
 * @package Echo Theme
 * @author 宁采陈
 * @version 3.0
 * @link https://www.ncc.wang
 *
 * ｅｅｅｅｅｅｅ　　　　　　　　　　　ｅｅｅ　　　　　　　　　　　　　　　　　　　　
 * ｅｅｅｅｅｅｅ　　　　　　　　　　　ｅｅｅ　　　　　　　　　　　　　　　　　　　　
 * ｅｅｅｅ　　　　　　　ｅｅｅｅｅｅ　ｅｅｅｅｅｅｅ　　　　ｅｅｅｅｅｅ　
 * ｅｅｅｅ　　　　　　ｅｅｅｅｅｅｅ　ｅｅｅｅｅｅｅ　　　ｅｅｅｅｅｅｅｅ
 * ｅｅｅｅｅｅｅ　　　ｅｅｅｅｅｅｅ　ｅｅｅｅｅｅｅｅ　 ｅｅｅｅｅｅｅｅｅ
 * ｅｅｅｅｅｅｅ　　ｅｅｅｅ　　　　　ｅｅｅ　ｅｅｅｅ　 ｅｅｅ　　　ｅｅｅ　　　
 * ｅｅｅｅ　　　　　ｅｅｅｅ　　　　　ｅｅｅ　　ｅｅｅ　 ｅｅｅ　　　ｅｅｅ　　　
 * ｅｅｅｅ　　　　　　ｅｅｅｅ　　ｅ　ｅｅｅ　　ｅｅｅ　 ｅｅｅ　　　ｅｅｅ　　　
 * ｅｅｅｅｅｅｅｅ　　ｅｅｅｅｅｅｅ　ｅｅｅ　　ｅｅｅ　　ｅｅｅｅｅｅｅｅ　　　
 * ｅｅｅｅｅｅｅｅ　　　ｅｅｅｅｅｅ　ｅｅｅ　　ｅｅｅ　　　ｅｅｅｅｅｅ　　　
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('Common/header.php');
?>

<div class="layui-container">
    <?php $this->need('Common/searchs.php'); ?>

    <?php if (!empty($this->options->bigCarouselSwitch) && $this->options->bigCarouselSwitch == 'true'): ?>
        <div class="layui-carousel main" id="bigCarousel" style="padding: 0 7.5px;">
            <div carousel-item="">
                <?php $this->options->bigCarouselText() ?>
            </div>
        </div>
        <script>
            layui.use('carousel', function(){
                var carousel = layui.carousel;
                //建造实例
                carousel.render({
                    elem: '#bigCarousel'
                    ,width: '100%'
                    ,height: '<?php echo $this->options->bigCarouselHeight?$this->options->bigCarouselHeight:'180px'; ?>'
                    ,arrow: 'always'
                });
            });
        </script>
    <?php endif; ?>

    <div class="layui-row layui-col-space15 main">

        <div class="layui-col-md9 layui-col-lg9">

            <?php if (!empty($this->options->smallCarouselSwitch) && $this->options->smallCarouselSwitch == 'true'): ?>
                <div class="layui-carousel list-card" id="smallCarousel">
                    <div carousel-item="">
                        <?php $this->options->smallCarouselText() ?>
                    </div>
                </div>
                <script>
                    layui.use('carousel', function(){
                        var carousel = layui.carousel;
                        //建造实例
                        carousel.render({
                            elem: '#smallCarousel'
                            ,width: '100%'
                            ,height: '<?php echo $this->options->smallCarouselHeight?$this->options->smallCarouselHeight:'180px'; ?>'
                            ,arrow: 'always'
                        });
                    });
                </script>
            <?php endif; ?>

            <?php while($this->next()): ?>
                <div class="title-article list-card">
                    <?php if (!empty($this->options->thumbType)): ?>
                        <div class="list-pic">
                            <a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>">
                                <img src="<?php $thumb = 'thumb'.$this->options->thumbType; echo $thumb($this); ?>" alt="<?php $this->title() ?>" class="img-full">
                            </a>
                        </div>
                    <?php endif; ?>
                    <a href="<?php $this->permalink() ?>">
                        <h1><?php $this->title() ?></h1>
                        <p>
                            <?php $this->excerpt(300, '...'); ?>
                        </p>
                    </a>
                    <div class="title-msg">
                        <span><i class="layui-icon">&#xe705;</i> <?php $this->category(','); ?></span>
                        <span><i class="layui-icon">&#xe60e;</i> <?php $this->date('Y-m-d A'); ?> </span>
                        <span class="layui-hide-xs"><i class="layui-icon">&#xe62c;</i> <?php get_post_view($this); ?>℃</span>
                        <span class="layui-hide-xs"><i class="layui-icon">&#xe63a;</i> <?php $this->commentsNum('%d'); ?>条</span>
                    </div>
                </div>
            <?php endwhile; ?>
            <div class="page-navigator">
                <?php $this->pageNav('«', '»', 1, '...', array('wrapTag' => 'div', 'wrapClass' => 'layui-laypage layui-laypage-molv', 'itemTag' => '', 'currentClass' => 'current', )); ?>
            </div>
        </div>

        <?php $this->need('Common/sidebar.php'); ?>

    </div>
</div>

<?php $this->need('Common/footer.php'); ?>
