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
    <link rel="shortcut icon" href="<?php $this->options->themeUrl('public/home/img/favicon.png'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('public/lib/layui/css/layui.css'); ?>?v=2.6.8">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('public/home/css/style.css'); ?>?t=<?php echo time(); ?>">
    <script src="<?php $this->options->themeUrl('public/lib/layui/layui.js'); ?>?v=2.6.8"></script>
    <script src="<?php $this->options->themeUrl('public/home/js/main.js'); ?>?v=3.0"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.3.1/build/styles/github<?php if ($this->options->codeStyle == '1'){echo '-dark';} ?>.min.css">
    <script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.3.1/build/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

    <style>
        <?php if (!empty($this->options->navFixed) && $this->options->navFixed == 'true'): ?>
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
        <?php if ($this->options->codeStyle == '1'): ?>
        pre {
            background: #282C34;
        }
        pre code[class*='language-'] {
            background: #0d1117;
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
            /*.header .layui-nav .layui-nav-more {*/
            /*    border-color: */<?php //$this->options->headerTextColor(); ?>/* transparent transparent;*/
            /*}*/
            /*.header .layui-nav .layui-nav-mored {*/
            /*    border-color: transparent transparent */<?php //$this->options->headerTextColor(); ?>/*;*/
            /*}*/
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
    <link rel="stylesheet" href="<?php $this->options->themeUrl('public/home/css/dark.css'); ?>?t=<?php echo time(); ?>">
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

			<?php
                //栏目分类内容
                $category = '';
                $Category_List = $this->widget('Widget_Metas_Category_List');
                if($Category_List->have()){
                    while($Category_List->next()){
                        if($Category_List->levels==0){
							$layui_this = '';
							if($this->is('page', $Category_List->slug)){
								$layui_this = 'layui-this';
							}

                            $category .= '<li class="layui-nav-item layui-hide-xs '.$layui_this.'">'.
                                '<a href="'.$Category_List->permalink.'" title="'.$Category_List->name.'">'.$Category_List->name.'</a>';

                            $childrens = $this->widget('Widget_Metas_Category_List')->getAllChildren($Category_List->mid);
                            if($childrens){
                                $category .= '<dl class="layui-nav-child">';
                                for ($i=0; $i <count($childrens) ; $i++) {
                                    $thisChild = $this->widget('Widget_Metas_Category_List')->getCategory($childrens[$i]);
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
                $Page_List = $this->widget('Widget_Contents_Page_List');
                if($Page_List->have()){
                    while($Page_List->next()){
						$layui_this = '';
                        if($this->is('page', $Page_List->slug)){
							$layui_this = 'layui-this';
                        }

                        $page .= '<li class="layui-nav-item layui-hide-xs '.$layui_this.'">'.
                            '<a href="'.$Page_List->permalink.'" title="'.$Page_List->title.'">'.$Page_List->title.'</a>'.
                            '</li>';
                    }
                }
			?>

			<?php if ($this->options->nav==0): ?><?php echo $page; ?><?php endif; ?>
			<?php if ($this->options->nav==1): ?><?php echo $category; ?><?php endif; ?>
			<?php if ($this->options->nav==2): ?><?php echo $page.$category; ?><?php endif; ?>
			<?php if ($this->options->nav==3): ?><?php echo $category.$page; ?><?php endif; ?>

            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
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
