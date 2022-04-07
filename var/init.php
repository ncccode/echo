<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

define('__ECHO_VERSION__', '3.1.0');
define('__TYPECHO_DIR_NAME__', basename(dirname(__DIR__)));

if(defined('__RUN_FUNCTIONS__')){
	if(!Typecho_Common::isAvailableClass('Echo_Themes')){
		if (is_writeable(__TYPECHO_ROOT_DIR__ . '/config.inc.php')) {
			$handle = fopen(__TYPECHO_ROOT_DIR__ . '/config.inc.php', 'ab');
			fwrite($handle, '
/** 初始化主题 */
@require_once __TYPECHO_ROOT_DIR__ . __TYPECHO_THEME_DIR__ . "/' . __TYPECHO_DIR_NAME__ . '/var/init.php";
');
			fclose($handle);
		} else {
			throw new Typecho_Exception(_t('出错啦！config.inc.php 文件无法写入, 请将它的权限设置为可写'));
		}
	}
}else{
	/** 设置自动载入函数 */
	spl_autoload_register(function (string $className) {
		$path = str_replace(array('\\', '_'), '/', $className) . '.php';
		$pluginFile = __TYPECHO_ROOT_DIR__ . __TYPECHO_THEME_DIR__ . '/' . __TYPECHO_DIR_NAME__ . '/var/' . $path;
		if (file_exists($pluginFile)) {
			include_once $pluginFile;
		} else {
			return;
		}
	});
}
