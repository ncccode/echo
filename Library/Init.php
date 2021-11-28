<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Echo_Init
{
    public static function init($form) {
        if($form->action==NULL){
			//配置处理
			$db = Typecho_Db::get();
			$options = Typecho_Widget::widget('Widget_Options');
			$settings = $options->__get('theme:Echo');
			if (!$settings) {
				$echo = $options->__get('theme:echo');
				if ($echo) {
					$db->query($db->update('table.options')->rows(array('name' => 'theme:Echo'))->where('name = ?', 'theme:echo'));
				}else{
					$data = array(
						'nav'=>0,
						'navFixed'=>'true',
						'sidebar'=>'1,2,5',
						'gravatar'=>'http://gravatar.echo.so/avatar/'
					);
					$db->query($db->insert('table.options')->rows(array(
						'name'  =>  'theme:Echo',
						'value' =>  serialize($data),
						'user'  =>  0
					)));
				}
			}
            self::config();
            self::echo();
            @set_include_path(get_include_path() . PATH_SEPARATOR .__TYPECHO_ROOT_DIR__ . __TYPECHO_THEME_DIR__);
            Echo_Library_Themes::start();
        }else{
            $Html = <<<HTML
                <style>
                    button.btn.primary {
                        display: none
                    }
                </style>
                <div class="layui-card">
                    <div class="layui-card-header">Echo 3.0.0</div>
                    <div class="layui-card-body">
                        宁采陈<br>
                        Typecho全新主题3.0
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

    private static function config(){
        if(!Typecho_Common::isAvailableClass('Echo_Library_Themes')){
			if (is_writeable(__TYPECHO_ROOT_DIR__ . '/config.inc.php')) {
				$handle = fopen(__TYPECHO_ROOT_DIR__ . '/config.inc.php', 'ab');
                fwrite($handle, '
/** 设置包含主题目录路径 */
@set_include_path(get_include_path() . PATH_SEPARATOR .__TYPECHO_ROOT_DIR__ . __TYPECHO_THEME_DIR__);
');
				fclose($handle);
			} else {
				throw new Typecho_Exception(_t('出错啦！config.inc.php 文件无法写入, 请将它的权限设置为可写'));
			}
		}
    }

    private static function echo(){
        if (is_writeable(__TYPECHO_ROOT_DIR__ . '/admin')) {
            $handle = fopen(__TYPECHO_ROOT_DIR__ . '/admin/extending.php', 'wb');
            fwrite($handle, '<?php
include "common.php";
$panel = $request->get("panel");
$panelTable = unserialize($options->panelTable);
if (!isset($panelTable["file"]) || !in_array(urlencode($panel), $panelTable["file"])) {
    throw new Typecho_Plugin_Exception(_t("页面不存在"), 404);
}
list ($pluginName, $file) = explode("/", trim($panel, "/"), 2);

$plugin = $options->pluginDir($pluginName) . "/" . $panel;
if (file_exists($plugin)) {
	require_once $plugin;
}else{
	$echo = $options->themeFile("Echo","Panel") . "/" . $panel;
	if (file_exists($echo)) {
		require_once $echo;
	}
}
');
            fclose($handle);
        } else {
            throw new Typecho_Exception(_t('出错啦！admin 目录无法写入, 请将它的权限设置为可写'));
        }
    }
}
