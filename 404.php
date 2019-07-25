<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>404 - <?php $this->options->title(); ?></title>	
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/404.css'); ?>">
</head>
<body>
	<div id="page-wrapper">    
		<div class="page-blank-wrap">
			<div class="site-error">
				<h1 class="headline"><img src="<?php $this->options->themeUrl('img/404.png'); ?>" alt="404"></h1>
				<div class="error-content">
					<h4>海面雾气太大</h4><h4>受天气影响，该页无法正常显示</h4>
					<h5> 你可以 <a href="<?php $this->options->siteUrl(); ?>">返回首页</a> 。</h5>
				</div>
				<img src="<?php $this->options->themeUrl('img/error-bg.png'); ?>" style="padding:20px 0 120px;">
			</div>
		</div> 	   
	</div>

</body></html>