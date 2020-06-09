<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?> ~ 个人博客</title>

    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>
    <link rel="shortcut icon" href="<?php $this->options->themeUrl('img/favicon.png'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('layui/css/layui.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css'); ?>?t=<?php echo time(); ?>">
    <script src="<?php $this->options->themeUrl('layui/layui.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('js/main.js'); ?>"></script>

    <style>
        <?php if (!empty($this->options->navFixed) && $this->options->navFixed == 'checked'): ?>
            .header {
                position: fixed;
                left: 0;
                top: 0;
                z-index: 10000;
                width: 100%;
            }
            .layui-container {
                margin-top: 70px;
            }
            .timeline-menu-fixed {
                top: 70px;
            }
            .timeline-header h2 {
                margin-top: -70px;
                padding-top: 70px;
            }
        <?php endif; ?>
        <?php if (!empty($this->options->headerColor)): ?>
            .header {
                background-color: <?php $this->options->headerColor(); ?>;
            }
        <?php endif; ?>
        <?php if (!empty($this->options->headerTextColor)): ?>
            .header a{
                color: <?php $this->options->headerTextColor(); ?>;
            }
            .header .layui-nav .layui-nav-item a {
                color: <?php $this->options->headerTextColor(); ?>;
            }
            .header .layui-nav .layui-nav-item .layui-nav-child a {
                color: #212220;
            }
            .header .layui-nav .layui-nav-more {
                border-color: <?php $this->options->headerTextColor(); ?> transparent transparent;
            }
            .header .layui-nav .layui-nav-mored {
                border-color: transparent transparent <?php $this->options->headerTextColor(); ?>;
            }
        <?php endif; ?>
        <?php if (!empty($this->options->footerColor)): ?>
            .footer {
                background: <?php $this->options->footerColor(); ?>;
            }
        <?php endif; ?>
        <?php if (!empty($this->options->footerTextColor)): ?>
            .footer span {
                color: <?php $this->options->footerTextColor(); ?>;
            }
            .footer .layui-breadcrumb a {
                color: <?php $this->options->footerTextColor(); ?> !important;
            }
            .footer .layui-breadcrumb span[lay-separator] {
                color: <?php $this->options->footerTextColor(); ?>;
            }
        <?php endif; ?>
        <?php if (!empty($this->options->backgroundColor)): ?>
            body {
                background: <?php $this->options->backgroundColor(); ?>;
            }
            .layui-carousel {
                background: <?php $this->options->backgroundColor(); ?>;
            }
        <?php endif; ?>
        <?php if (!empty($this->options->backgroundImg)): ?>
            body {
                background-image:url(<?php $this->options->backgroundImg(); ?>);
                background-repeat: round;
            }
        <?php endif; ?>
    </style>
</head>
<body>
<!--[if lt IE 8]>
    <div class="browsehappy" role="dialog"><?php _e('当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a href="http://browsehappy.com/">升级你的浏览器</a>'); ?>.</div>
<![endif]-->

<div class="layui-header header">
    <div class="layui-main">
        <a class="logo" href="<?php $this->options->siteUrl(); ?>">
            <?php if ($this->options->logoUrl): ?><img src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>" /><?php endif; ?>
            <?php if ($this->options->title): ?><?php $this->options->title() ?><?php endif; ?>
        </a>
        
        <ul class="layui-nav">
            <li class="layui-nav-item layui-hide-xs <?php if($this->is('index')): ?>layui-this<?php endif; ?>">
                <a href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a> 
            </li>
            <?php if (!empty($this->options->navItem) && $this->options->navItem == 'checked'): ?>
            <li class="layui-nav-item layui-hide-xs">
                <a href="javascript:;"><?php if ($this->options->navItemTitle): ?><?php $this->options->navItemTitle() ?><?php else: ?>栏目分类<?php endif; ?></a>
                <dl class="layui-nav-child">
                    <?php $this->widget('Widget_Metas_Category_List')
                        ->parse('<dd><a href="{permalink}">{name}</a></dd>'); ?>
                </dl>
            </li>
            <?php endif; ?>
            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            <?php while($pages->next()): ?>
            <li class="layui-nav-item layui-hide-xs <?php if($this->is('page', $pages->slug)): ?>layui-this<?php endif; ?>">
                <a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a> 
            </li>
            <?php endwhile; ?>
            
            <li class="layui-nav-item nav-btn layui-hide-sm">
                <a href="javascript:;"><i class='layui-icon layui-icon-more'></i></a>
                <dl class="layui-nav-child">
                    <?php while($pages->next()): ?>
                        <dd><a href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a></dd>
                    <?php endwhile; ?>
                </dl>
            </li>
        </ul>
    </div>
</div>