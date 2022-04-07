<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

define('__RUN_FUNCTIONS__', true);

require_once dirname(__FILE__) . '/var/init.php';

// 主题设置
function themeConfig($form) {
	if($form->action==NULL){
		//配置处理
		$db = Typecho_Db::get();
		$options = Typecho_Widget::widget('Widget_Options');
		$echo = $options->__get('theme:echo');
		if (!$echo) {
			$data = array(
				'nav'=>0,
				'navFixed'=>'true',
				'sidebar'=>'1,2,5',
				'gravatar'=>'https://gravatar.echo.so/avatar/'
			);
			$db->query($db->insert('table.options')->rows(array(
				'name'  =>  'theme:echo',
				'value' =>  serialize($data),
				'user'  =>  0
			)));

		}
		require_once 'var/Echo/Themes.php';
		Echo_Themes::start();
	}else{
		$Html = <<<HTML
                <style>
                    button.btn.primary {
                        display: none
                    }
                </style>
                <div class="layui-card">
                    <div class="layui-card-header">Echo 3.1.0</div>
                    <div class="layui-card-body">
                        宁采陈<br>
                        Typecho全新主题3.1
                    </div>
                </div>
                <script>
                layui.use(['jquery'], function(){
                    var $ = layui.jquery;
                    $("div[role='form']").removeClass("col-tb-8").removeClass("col-tb-offset-2");
                });
                </script>
HTML;
		$layout = new Typecho_Widget_Helper_Layout();
		$layout->html(_t($Html));
		$form->addItem($layout);
	}
}

// 统计阅读数
function get_post_view($archive){
	$cid    = $archive->cid;
	$db     = Typecho_Db::get();
	$prefix = $db->getPrefix();
	if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
		$db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
		echo 0;
		return;
	}
	$row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
	if ($archive->is('single')) {
		$views = Typecho_Cookie::get('extend_contents_views');
		if(empty($views)){
			$views = array();
		}else{
			$views = explode(',', $views);
		}
		if(!in_array($cid,$views)){
			$db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
			array_push($views, $cid);
			$views = implode(',', $views);
			Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
		}
	}
	echo $row['views'];
}

// 获取附件首张图片
function thumb1($obj) {
	$attach = $obj->attachments(1)->attachment;
	if(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else{
		$thumb = '/usr/themes/echo/public/home/img/00.png';
	}
	return $thumb;
}

// 获取文章首张图片
function thumb2($obj) {
	preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $obj->content, $thumbUrl);
	$img_src = $thumbUrl[1][0];
	if($img_src){
		$thumb = $img_src;
	}else{
		$thumb = '/usr/themes/echo/public/home/img/00.png';
	}
	return $thumb;
}

// 获取自定义随机图片
function thumb3($obj) {
	$options = Typecho_Widget::widget('Widget_Options');
	$thumbs = explode("|",$options->thumbs);
	if($options->thumbs && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)];
	}else{
		$thumb = '/usr/themes/echo/public/home/img/00.png';
	}
	return $thumb;
}

// 留言加@
function getPermalinkFromCoid($coid) {
	$db = Typecho_Db::get();
	$row = $db->fetchRow($db->select('author')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
	if (empty($row)) return '';
	return '<a href="#comment-'.$coid.'">@'.$row['author'].'</a>';
}

// 解析头像
function getAvatar($mail)
{
	$gravatar = Typecho_Widget::widget('Widget_Options')->gravatar;
	$mail = strtolower(trim($mail));
	$qq = str_replace('@qq.com', '', $mail);
	if (strstr($mail, "qq.com") && is_numeric($qq) && strlen($qq) < 11 && strlen($qq) > 4) {
		$url = '//thirdqq.qlogo.cn/g?b=qq&nk=' . $qq . '&s=100';
	} else {
		$url = $gravatar . md5($mail) . '?s=40&r=G&d=';
	}
	return $url;
}
