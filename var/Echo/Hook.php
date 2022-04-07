<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Echo_Hook extends Typecho_Widget
{
    public static function header($header) {
        $options = Helper::options();
        list($prefixVersion, $suffixVersion) = explode('/', $options->version);
        $themeFile = $options->themeUrl('public',__TYPECHO_DIR_NAME__);
        $header = PHP_EOL.
        '<link rel="stylesheet" href="'.$themeFile.'/lib/layui/css/layui.css?v=2.6.8">'.PHP_EOL.
        '<link rel="stylesheet" href="'.$themeFile.'/admin/css/grid.css?v='.__ECHO_VERSION__.'">'.PHP_EOL.
        '<link rel="stylesheet" href="'.$themeFile.'/admin/css/echo.css?v='.__ECHO_VERSION__.'">'.PHP_EOL.
        '<script src="'.$themeFile.'/lib/layui/layui.js?v=2.6.8"></script>'.PHP_EOL;
        return $header;
    }

    public static function footer() {
        $themeFile = Helper::options()->themeUrl('public',__TYPECHO_DIR_NAME__);
        echo PHP_EOL.'<script src="'.$themeFile.'/admin/js/echo.js?v='.__ECHO_VERSION__.'"></script>';
    }

	public static function common() {
		$options = Helper::options();
		if($options->gravatar){
			define('__TYPECHO_GRAVATAR_PREFIX__',$options->gravatar);
		}

		if($_SERVER['PHP_SELF'] == '/admin/extending.php'){
			$panel = $options->request->get('panel');
			$panelTable = unserialize($options->panelTable);
			if (!isset($panelTable['file']) || !in_array(urlencode($panel), $panelTable['file'])) {
				throw new Typecho_Plugin_Exception(_t('页面不存在'));
			}

			$panelFile = $options->themeFile('echo','usr/panel') . '/' . $panel;
			if (file_exists($panelFile)) {
				require_once $panelFile;
				error_reporting(0);
			}
		}

	}

    // 获取当前所有自定义模板
    public static function getTemplates()
    {
        $options = Helper::options();
        $files = glob($options->themeFile($options->theme, 'usr/themes/*.php'));
        $result = [];

        foreach ($files as $file) {
            $info = Typecho_Plugin::parseInfo($file);
            $file = basename($file);

            if ('index.php' != $file && 'custom' == $info['title']) {
                $result[$file] = $info['description'];
            }
        }

        return $result;
    }

	// 自定义模板
	public static function write_page_option($page)
	{
        $option = '<option value="">不选择</option>';
        $templates = self::getTemplates();
        foreach ($templates as $template => $name) {
            $option .= '<option value="' . $template . '" ' . ($page->template == $template ? 'selected' : '') . '>' . $name . '</option>';
        }

		echo '<script>window.onload = function(){var template = document.getElementById("template");';
		echo "template.innerHTML = '".$option."';";
		echo '}</script>';
	}


}
