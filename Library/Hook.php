<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Echo_Library_Hook extends Typecho_Widget
{
    public static function header($header) {
        $options = Helper::options();
        list($prefixVersion, $suffixVersion) = explode('/', $options->version);
        $themeFile = $options->themeUrl('Public','Echo');
        $header = PHP_EOL.
        '<link rel="stylesheet" href="'.$themeFile.'/lib/layui/css/layui.css?v=2.6.8">'.PHP_EOL.
        '<link rel="stylesheet" href="'.$themeFile.'/admin/css/grid.css?v=3.0">'.PHP_EOL.
        '<link rel="stylesheet" href="'.$themeFile.'/admin/css/echo.css?v=3.0">'.PHP_EOL.
        '<script src="'.$themeFile.'/lib/layui/layui.js?v=2.6.8"></script>'.PHP_EOL;
        return $header;
    }

    public static function footer() {
        $themeFile = Helper::options()->themeUrl('Public','Echo');
        echo PHP_EOL.'<script src="'.$themeFile.'/admin/js/echo.js?v=1"></script>';
    }

	public static function common() {
		$options = Helper::options();
		if($options->gravatar){
			define('__TYPECHO_GRAVATAR_PREFIX__',$options->gravatar);
		}
	}
}
