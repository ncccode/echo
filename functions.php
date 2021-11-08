<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

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
		$thumb = '/usr/themes/echo/img/00.png';
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
		$thumb = '/usr/themes/echo/img/00.png';
	}
	return $thumb;
}

// 获取自定义随机图片
function thumb3($obj) {
	$options = Typecho_Widget::widget('Widget_Options');
	$thumbs = explode("|",$options->thumbs);
	$cid = intval($obj->cid);
	$thumbsLength = count($thumbs);
	if($options->thumbs && $thumbsLength>0){
		$thumb = $thumbs[$cid%$thumbsLength];
	}else{
		$thumb = '/usr/themes/echo/img/00.png';
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

// 主题设置
function themeConfig($form) {
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('logoUrl'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('title'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('navFixed'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('headerColor'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('headerTextColor'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('footerColor'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('footerTextColor'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('backgroundColor'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('backgroundImg'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('navItem'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('navItemTitle'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('bigCarouselSwitch'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('bigCarouselHeight'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('bigCarouselText'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('smallCarouselSwitch'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('smallCarouselHeight'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('smallCarouselText'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('thumbType'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('thumbs'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('linksText'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('linksUrl'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('links'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('sidebar'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('adsText'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('ads'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('mylifeName'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('mylifeJob'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('mylifeAvatar'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('mylifeDesc'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('mylifeBtn'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('script'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('isShow'));

	$options = Typecho_Widget::widget('Widget_Options');

	$Html = <<<HTML
	<link rel="stylesheet" href="/usr/themes/echo/layui/css/layui.css?v=2.5.6">
	<script src="/usr/themes/echo/layui/layui.js?v=2.5.6"></script>

	<fieldset class="layui-elem-field">
		<legend>个性化配置面板</legend>
		<div class="layui-field-box">
			<div class="layui-form-item">
				<label class="layui-form-label">网站 LOGO</label>
				<div class="layui-input-block">
					<input type="text" name="echo_logoUrl" value="{$options->logoUrl}" placeholder="网站 LOGO 地址" autocomplete="off" class="layui-input">
					<div class="layui-word-aux">留空则不显示；在这里填入一个图片 URL 地址, 可以在网站标题前加上一个 LOGO</div>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">网站 标题</label>
				<div class="layui-input-block">
					<input type="text" name="echo_title" value="{$options->title}" placeholder="网站 标题" autocomplete="off" class="layui-input">
					<div class="layui-word-aux">留空则不显示</div>
				</div>
			</div>
			<hr>
			<div class="layui-form-item">
				<label class="layui-form-label">开启排名</label>
				<div class="layui-input-inline">
					<input type="checkbox" name="echo_isShow" value="checked" lay-skin="switch" lay-text="开启|关闭" {$options->isShow} >
					<div class="layui-word-aux">开启后，将在<a href="https://user.echo.so/" target="_blank">https://user.echo.so/</a>显示</div>
				</div>
			</div>
			<hr>
			<div class="layui-form-item">
				<label class="layui-form-label">导航条悬浮</label>
				<div class="layui-input-inline">
					<input type="checkbox" name="echo_navFixed" value="checked" lay-skin="switch" lay-text="开启|关闭" {$options->navFixed} >
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">导航条颜色</label>
					<div class="layui-input-inline" style="width: 120px;">
						<input type="text" name="echo_headerColor" value="{$options->headerColor}" placeholder="请选择颜色" class="layui-input" id="headerColor-input">
					</div>
					<div class="layui-inline" style="left: -11px;">
						<div id="headerColor"></div>
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">文字颜色</label>
					<div class="layui-input-inline" style="width: 120px;">
						<input type="text" name="echo_headerTextColor" value="{$options->headerTextColor}" placeholder="请选择颜色" class="layui-input" id="headerTextColor-input">
					</div>
					<div class="layui-inline" style="left: -11px;">
						<div id="headerTextColor"></div>
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">页脚颜色</label>
					<div class="layui-input-inline" style="width: 120px;">
						<input type="text" name="echo_footerColor" value="{$options->footerColor}" placeholder="请选择颜色" class="layui-input" id="footerColor-input">
					</div>
					<div class="layui-inline" style="left: -11px;">
						<div id="footerColor"></div>
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">文字颜色</label>
					<div class="layui-input-inline" style="width: 120px;">
						<input type="text" name="echo_footerTextColor" value="{$options->footerTextColor}" placeholder="请选择颜色" class="layui-input" id="footerTextColor-input">
					</div>
					<div class="layui-inline" style="left: -11px;">
						<div id="footerTextColor"></div>
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">背景颜色</label>
					<div class="layui-input-inline" style="width: 120px;">
						<input type="text" name="echo_backgroundColor" value="{$options->backgroundColor}" placeholder="请选择颜色" class="layui-input" id="backgroundColor-input">
					</div>
					<div class="layui-inline" style="left: -11px;">
						<div id="backgroundColor"></div>
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">背景图</label>
					<div class="layui-input-inline">
						<input type="text" name="echo_backgroundImg" value="{$options->backgroundImg}" placeholder="背景图片链接" class="layui-input">
					</div>
				</div>
			</div>
			<hr>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">导航条<br/>栏目分类</label>
					<div class="layui-input-inline" style="width: 80px;">
						<input type="checkbox" name="echo_navItem" value="checked" lay-skin="switch" lay-text="开启|关闭" {$options->navItem} >
					</div>
					<label class="layui-form-label">显示文字</label>
					<div class="layui-input-inline" style="width: 140px;">
						<input type="text" name="echo_navItemTitle" value="{$options->navItemTitle}" placeholder="栏目分类标题" autocomplete="off" class="layui-input">
					</div>
				</div>
			</div>
			<hr>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">首页大横幅</label>
					<div class="layui-input-inline" style="width: 80px;">
						<input type="checkbox" name="echo_bigCarouselSwitch" value="checked" lay-skin="switch" lay-text="开启|关闭" {$options->bigCarouselSwitch} >
					</div>
					<label class="layui-form-label">高度</label>
					<div class="layui-input-inline" style="width: 140px;">
						<input type="text" name="echo_bigCarouselHeight" value="{$options->bigCarouselHeight}" placeholder="设定轮播容器宽度" autocomplete="off" class="layui-input">
					</div>
					<div class="layui-form-mid">支持像素和百分比，如：180px</div>
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">大横幅内容</label>
				<div class="layui-input-block">
					<textarea name="echo_bigCarouselText" placeholder='请输入轮播内容,例如\r\n<img src="xxx.jpg" />\r\n<a href="xxx"><img src="xxx" /></a>' class="layui-textarea">{$options->bigCarouselText}</textarea>
				</div>
			</div>
			<hr>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">首页小横幅</label>
					<div class="layui-input-inline" style="width: 80px;">
						<input type="checkbox" name="echo_smallCarouselSwitch" value="checked" lay-skin="switch" lay-text="开启|关闭" {$options->smallCarouselSwitch} >
					</div>
					<label class="layui-form-label">高度</label>
					<div class="layui-input-inline" style="width: 140px;">
						<input type="text" name="echo_smallCarouselHeight" value="{$options->smallCarouselHeight}" placeholder="设定轮播容器宽度" autocomplete="off" class="layui-input">
					</div>
					<div class="layui-form-mid">支持像素和百分比，如：180px</div>
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">小横幅内容</label>
				<div class="layui-input-block">
					<textarea name="echo_smallCarouselText" placeholder='请输入轮播内容,例如\r\n<img src="xxx.jpg" />\r\n<a href="xxx"><img src="xxx" /></a>' class="layui-textarea">{$options->smallCarouselText}</textarea>
				</div>
			</div>
			<hr>
			<div class="layui-form-item">
				<label class="layui-form-label">文章首页<br/>缩略图方式</label>
				<div class="layui-input-block">
					<input type="radio" name="echo_thumbType" value="" title="不显示">
					<input type="radio" name="echo_thumbType" value="1" title="取附件首图">
					<input type="radio" name="echo_thumbType" value="2" title="取文章首图">
					<input type="radio" name="echo_thumbType" value="3" title="自定义随机">
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">自定义随机图片</label>
				<div class="layui-input-block">
					<textarea name="echo_thumbs" placeholder='首页文章列表缩略图，自定义图片链接\r\n可固定一张，多张随机使用|分割\r\n例如\r\nhttps://www.xxx.com/xxx.jpg|\r\nhttps://www.xxx.com/xxx.jpg' class="layui-textarea">{$options->thumbs}</textarea>
				</div>
			</div>
			<hr>
			<div class="layui-form-item">
				<label class="layui-form-label">侧边栏</label>
				<div id="sidebar"></div>
			</div>
			<hr>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">广而告之</label>
				<div class="layui-inline">
					<label class="layui-form-label">文字</label>
					<div class="layui-input-inline" style="width: 80px;">
						<input type="text" name="echo_adsText" value="{$options->adsText}" placeholder="标题文字" autocomplete="off" class="layui-input">
					</div>
				</div>
				<div class="layui-input-block">
					<textarea name="echo_ads" placeholder='友情链接,例如:\r\n<a href="https://www.echo.so" title="描述" target="_blank"><img src="xxx.png" alt="描述"></a>' class="layui-textarea">{$options->ads}</textarea>
				</div>
			</div>
			<hr>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">友情链接</label>
				<div class="layui-inline">
					<label class="layui-form-label">申请文字</label>
					<div class="layui-input-inline" style="width: 80px;">
						<input type="text" name="echo_linksText" value="{$options->linksText}" placeholder="申请文字" autocomplete="off" class="layui-input">
					</div>
					<label class="layui-form-label">申请地址</label>
					<div class="layui-input-inline" style="width: 140px;">
						<input type="text" name="echo_linksUrl" value="{$options->linksUrl}" placeholder="添加友情链接申请地址" autocomplete="off" class="layui-input">
					</div>
				</div>
				<div class="layui-input-block">
					<textarea name="echo_links" placeholder='广告内容,例如:\r\n<a href="https://www.echo.so" title="描述" target="_blank">名称</a>\r\n<a href="https://www.echo.so" title="描述" target="_blank">名称</a>' class="layui-textarea">{$options->links}</textarea>
				</div>
			</div>
			<hr>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">博主动态：</label>
			</div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">昵称</label>
					<div class="layui-input-inline" style="width: 80px;">
						<input type="text" name="echo_mylifeName" value="{$options->mylifeName}" placeholder="昵称" autocomplete="off" class="layui-input">
					</div>
					<label class="layui-form-label">职业</label>
					<div class="layui-input-inline" style="width: 80px;">
						<input type="text" name="echo_mylifeJob" value="{$options->mylifeJob}" placeholder="职业" autocomplete="off" class="layui-input">
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">头像地址</label>
				<div class="layui-input-block">
					<input type="text" name="echo_mylifeAvatar" value="{$options->mylifeAvatar}" placeholder="头像图片链接" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">简介描述</label>
				<div class="layui-input-block">
					<input type="text" name="echo_mylifeDesc" value="{$options->mylifeDesc}" placeholder="一句话简介" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">按钮组</label>
				<div class="layui-input-block">
					<textarea name="echo_mylifeBtn" placeholder='按钮组,例如:\r\n<a href="/about.html"> 关于我</a>' class="layui-textarea">{$options->mylifeBtn}</textarea>
				</div>
			</div>
			<hr>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">脚本代码</label>
				<div class="layui-input-block">
					<textarea name="echo_script" placeholder='可以放置js脚本代码之类,例如网站统计js：\r\n<div style="display:none">\r\n    <script type="text/javascript" src="xxx"></script>\r\n</div>' class="layui-textarea">{$options->script}</textarea>
				</div>
			</div>

		</div>
	</fieldset>
	
	<script>
		layui.use(["colorpicker","form","transfer"], function(){
			var $ = layui.$;
			var form = layui.form;
			var colorpicker = layui.colorpicker;
			var transfer = layui.transfer;

			colorpicker.render({
				elem: '#headerColor'
				,color: '{$options->headerColor}'
				,done: function(color){
					$('#headerColor-input').focus().val(color).blur();
				}
			});
			colorpicker.render({
				elem: '#headerTextColor'
				,color: '{$options->headerTextColor}'
				,done: function(color){
					$('#headerTextColor-input').focus().val(color).blur();
				}
			});
			colorpicker.render({
				elem: '#footerColor'
				,color: '{$options->footerColor}'
				,done: function(color){
					$('#footerColor-input').focus().val(color).blur();
				}
			});
			colorpicker.render({
				elem: '#footerTextColor'
				,color: '{$options->footerTextColor}'
				,done: function(color){
					$('#footerTextColor-input').focus().val(color).blur();
				}
			});
			colorpicker.render({
				elem: '#backgroundColor'
				,color: '{$options->backgroundColor}'
				,done: function(color){
					$('#backgroundColor-input').focus().val(color).blur();
				}
			});

			
			transfer.render({
				elem: '#sidebar'
				,title: ['可选列表', '显示列表']
				,data: [
					{"value": "1", "title": "搜索框"}
					,{"value": "2", "title": "栏目分类"}
					,{"value": "3", "title": "广而告之"}
					,{"value": "4", "title": "博主动态"}
					,{"value": "5", "title": "标签云"}
					,{"value": "6", "title": "友情链接"}
				]
				,value: [{$options->sidebar}]
				,id: 'sidebar'
				,onchange: function(data, index){
					var sidebar = [];
					var sidebarData = transfer.getData('sidebar');
					for(var key in sidebarData){
						sidebar.push(sidebarData[key]['value']);

					}
					$("input[name='sidebar']").val(sidebar.join());
				}
			});

			$("form").addClass("layui-form");
			$("input[name=echo_thumbType][value='']").attr("checked", '{$options->thumbType}' == '' ? true : false);
			$("input[name=echo_thumbType][value='1']").attr("checked", '{$options->thumbType}' == 1 ? true : false);
			$("input[name=echo_thumbType][value='2']").attr("checked", '{$options->thumbType}' == 2 ? true : false);
			$("input[name=echo_thumbType][value='3']").attr("checked", '{$options->thumbType}' == 3 ? true : false);
			form.render();

			//同步input值
			$('input').bind('input propertychange blur', function(){
				var name = $(this).attr("name").split('_')[1];
				$("input[name='"+name+"']").val($(this).val());
			});
			$('textarea').bind('input propertychange', function(){
				var name = $(this).attr("name").split('_')[1];
				$("input[name='"+name+"']").val($(this).val());
			});
			form.on('switch()', function(data){
				var that = data.elem;
				var name = $(that).attr("name").split('_')[1];
				var value = data.elem.checked?data.value:'';
				$("input[name='"+name+"']").val(value);
			}); 
			form.on('radio()', function(data){
				var that = data.elem;
				var name = $(that).attr("name").split('_')[1];
				$("input[name='"+name+"']").val(data.value);
			});
		});
	</script>
HTML;
	$layout = new Typecho_Widget_Helper_Layout();
	$layout->html(_t($Html));
	$form->addItem($layout);
}
