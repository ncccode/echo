<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Echo_Library_Themes
{

    private static $_plugins = array();

    public function __construct()
    {
        /** 初始化变量 */
        $this->_plugins = Typecho_Plugin::export();
    }

    //启用主题
    public static function start() {
        //钩子
        self::factory('admin/header.php:header','Echo_Library_Hook','header');
        self::factory('admin/footer.php:end','Echo_Library_Hook','footer');
		self::factory('admin/common.php:begin','Echo_Library_Hook', 'common');
        //添加扩展类
        Helper::addAction('echo', 'Echo_Library_Action');
        //接管主题启用路由
        Helper::addRoute('echo_themes_action', '/action/themes-edit', 'Echo_Library_Edit', 'action', 'index');
        //创建菜单
        $MenuIndex = Helper::addMenu('Echo');
		Helper::addPanel($MenuIndex, 'setting.php', '外观设置', '外观设置', 'administrator');
		Helper::addPanel($MenuIndex, 'config.php', '其他配置', '其他配置', 'administrator');
    }

    //关闭主题
    public static function stop() {
        //移除钩子
        self::del_factory('admin/header.php:header','Echo_Library_Hook','header');
        self::del_factory('admin/footer.php:end','Echo_Library_Hook','footer');
		self::del_factory('admin/common.php:begin','Echo_Library_Hook', 'common');
        //移除扩展类
        Helper::removeAction('echo');
        //移除主题启用路由
        Helper::removeRoute('echo_themes_action');
        //移除菜单
        $MenuIndex = Helper::removeMenu('Echo');
		Helper::removePanel($MenuIndex, 'setting.php');
		Helper::removePanel($MenuIndex, 'config.php');
    }

    //创建钩子
    private static function factory($handle,$class,$func){
        $db = Typecho_Db::get();
		$plugins = self::$_plugins;
		$plugins['handles'] = array_key_exists('handles', $plugins) ? $plugins['handles'] : array();
		$plugins['handles'][$handle][0] = array($class, $func);
        $db->query($db->update('table.options')->rows(array('value' => serialize($plugins)))->where('name = ?', 'plugins'));
        self::$_plugins = $plugins;
    }

    //删除钩子
    private static function del_factory($handle,$class,$func){
        $db = Typecho_Db::get();
		$plugins = self::$_plugins;
        $plugins['handles'] = array_key_exists('handles', $plugins) ? $plugins['handles'] : array();
        foreach ($plugins['handles'] as $k => &$v) {

            if ($handle==$k) {
                foreach ($v as $index => $handles) {
                    if($handles == array($class, $func)){
                        unset($v[$index]);
                    }
                }

                if (empty($plugins['handles'][$handle])) {
                    unset($plugins['handles'][$handle]);
                }
            }
        }
        $db->query($db->update('table.options')->rows(array('value' => serialize($plugins)))->where('name = ?', 'plugins'));
        self::$_plugins = $plugins;
    }

    //添加面板
    private static function addPanel($index, $fileName, $title, $subTitle, $level, $hidden = false, $addLink = '')
    {
        $options = Helper::options();
        $panelTable = unserialize($options->panelTable);
        $panelTable['child'] = empty($panelTable['child']) ? array() : $panelTable['child'];
        $panelTable['child'][$index] = empty($panelTable['child'][$index]) ? array() : $panelTable['child'][$index];
        $fileName = urlencode(trim($fileName, '/'));
        $panelTable['child'][$index][] = array($title, $subTitle, 'echo.php?panel=' . $fileName, $level, $hidden, $addLink);

        $panelTable['file'] = empty($panelTable['file']) ? array() : $panelTable['file'];
        $panelTable['file'][] = $fileName;
        $panelTable['file'] = array_unique($panelTable['file']);

        $db = Typecho_Db::get();
        Typecho_Widget::widget('Widget_Abstract_Options')->update(array('value' => ($options->panelTable = serialize($panelTable)))
        , $db->sql()->where('name = ?', 'panelTable'));

        end($panelTable['child'][$index]);
        return key($panelTable['child'][$index]);
    }

    //移除面板
    public static function removePanel($index, $fileName)
    {
        $options = Helper::options();
        $panelTable = unserialize($options->panelTable);
        $panelTable['child'] = empty($panelTable['child']) ? array() : $panelTable['child'];
        $panelTable['child'][$index] = empty($panelTable['child'][$index]) ? array() : $panelTable['child'][$index];
        $panelTable['file'] = empty($panelTable['file']) ? array() : $panelTable['file'];
        $fileName = urlencode(trim($fileName, '/'));

        if (false !== ($key = array_search($fileName, $panelTable['file']))) {
            unset($panelTable['file'][$key]);
        }

        $return = 0;
        foreach ($panelTable['child'][$index] as $key => $val) {
            if ($val[2] == 'echo.php?panel=' . $fileName) {
                unset($panelTable['child'][$index][$key]);
                $return = $key;
            }
        }

        $db = Typecho_Db::get();
        Typecho_Widget::widget('Widget_Abstract_Options')->update(array('value' => ($options->panelTable = serialize($panelTable)))
        , $db->sql()->where('name = ?', 'panelTable'));
        return $return;
    }
}
