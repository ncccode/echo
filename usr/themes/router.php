<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php

// 兼容1.1版本
if(version_compare(Helper::options()->version, '1.2.0', '<')){
    $this->themeDir = $this->_themeDir;
    $this->themeFile = $this->_themeFile;
    $this->archiveType = $this->_archiveType;
    $this->archiveSlug = $this->_archiveSlug;
    $this->archiveSingle = $this->_archiveSingle;
}

$this->themeDir .= 'usr/themes/';
$this->_themeDir .= 'usr/themes/';

$validated = false;

//~ 自定义模板
if (!empty($this->themeFile) && 'index.php' != $this->themeFile) {
	if (file_exists($this->themeDir . $this->themeFile)) {
		$validated = true;
	}
}


if (!$validated && !empty($this->archiveType)) {

	// 自定义模板
	if ('page' == $this->archiveType && $this->template) {
		/** 应用自定义模板 */
		if (file_exists($this->themeDir . $this->template)) {
			$validated = true;
			$this->themeFile = $this->template;
		}
	}

	//~ 首先找具体路径, 比如 category/default.php
	if (!$validated && !empty($this->archiveSlug)) {
		$themeFile = $this->archiveType . '/' . $this->archiveSlug . '.php';
		if (file_exists($this->themeDir . $themeFile)) {
			$this->themeFile = $themeFile;
			$validated = true;
		}
	}

	//~ 然后找归档类型路径, 比如 category.php
	if (!$validated) {
		$themeFile = $this->archiveType . '.php';
		if (file_exists($this->themeDir . $themeFile)) {
			$this->themeFile = $themeFile;
			$validated = true;
		}
	}



	//针对attachment的hook
	if (!$validated && 'attachment' == $this->archiveType) {
		if (file_exists($this->themeDir . 'page.php')) {
			$this->themeFile = 'page.php';
			$validated = true;
		} elseif (file_exists($this->themeDir . 'post.php')) {
			$this->themeFile = 'post.php';
			$validated = true;
		}
	}

	//~ 最后找归档路径, 比如 archive.php 或者 single.php
	if (!$validated && 'index' != $this->archiveType && 'front' != $this->archiveType) {
		$themeFile = $this->archiveSingle ? 'single.php' : 'archive.php';
		if (file_exists($this->themeDir . $themeFile)) {
			$this->themeFile = $themeFile;
			$validated = true;
		}
	}

	if (!$validated) {
		$themeFile = 'index.php';
		if (file_exists($this->themeDir . $themeFile)) {
			$this->themeFile = $themeFile;
			$validated = true;
		}
	}
}

/** 文件不存在 */
if (!$validated) {
	throw new Typecho_Plugin_Exception(_t('文件不存在'), 500);
}

/** 输出模板 */
require_once $this->themeDir . $this->themeFile;
