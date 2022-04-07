<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Echo_Edit extends Widget_Abstract_Options implements Widget_Interface_Do
{
    /**
     * 更换外观
     *
     * @access public
     * @param string $theme 外观名称
     * @return void
     * @throws Typecho_Widget_Exception
     */
    public function changeTheme($theme)
    {
        $theme = $this->request->change;
        $theme = trim($theme, './');
        if (is_dir($this->widget('Widget_Options')->themeFile($theme))) {

            $this->db->query($this->db->update('table.options')->rows(array('value' => $theme))->where('name = ?', 'theme'));

            /** 删除Echo主题相关钩子菜单动作 */
            Echo_Themes::stop();

            /** 解除首页关联 */
            if (0 === strpos($this->widget('Widget_Options')->frontPage, 'file:')) {
                $this->update(array('value' => 'recent'), $this->db->sql()->where('name = ?', 'frontPage'));
            }

            $configFile = $this->widget('Widget_Options')->themeFile($theme, 'functions.php');

            if (file_exists($configFile)) {
                require_once $configFile;

                if (function_exists('themeConfig')) {
                    $form = new Typecho_Widget_Helper_Form();
                    themeConfig($form);
                    $options = $form->getValues();

                    if ($options && !$this->configHandle($options, true)) {
                        $this->db->query($this->db->insert('table.options')->rows(array(
                            'name'  =>  'theme:' . $theme,
                            'value' =>  serialize($options),
                            'user'  =>  0
                        )));
                    }
                }
            }

            $this->widget('Widget_Notice')->highlight('theme-' . $theme);
            $this->widget('Widget_Notice')->set(_t("心好疼，你切换到其他主题了！"), 'success');
            $this->response->goBack();
        } else {
            throw new Typecho_Widget_Exception(_t('您选择的风格不存在'));
        }
    }

    /**
     * 编辑外观文件
     *
     * @access public
     * @param string $theme 外观名称
     * @param string $file 文件名
     * @return void
     * @throws Typecho_Widget_Exception
     */
    public function editThemeFile($theme, $file)
    {
        $path = $this->options->themeFile($theme, $file);

        if (file_exists($path) && is_writeable($path) && !Typecho_Common::isAppEngine()
            && (!defined('__TYPECHO_THEME_WRITEABLE__') || __TYPECHO_THEME_WRITEABLE__)) {
            $handle = fopen($path, 'wb');
            if ($handle && fwrite($handle, $this->request->content)) {
                fclose($handle);
                $this->widget('Widget_Notice')->set(_t("文件 %s 的更改已经保存", $file), 'success');
            } else {
                $this->widget('Widget_Notice')->set(_t("文件 %s 无法被写入", $file), 'error');
            }
            $this->response->goBack();
        } else {
            throw new Typecho_Widget_Exception(_t('您编辑的文件不存在'));
        }
    }

    /**
     * 配置外观
     *
     * @access public
     * @param string $theme 外观名
     * @return void
     */
    public function config($theme)
    {
        // 已经载入了外观函数
        $form = $this->widget('Widget_Themes_Config')->config();

        /** 验证表单 */
        if ($form->validate()) {
            $this->response->goBack();
        }

        $settings = $form->getAllRequest();

        if (!$this->configHandle($settings, false)) {
            if ($this->options->__get('theme:' . $theme)) {
                $this->update(array('value' => serialize($settings)),
                $this->db->sql()->where('name = ?', 'theme:' . $theme));
            } else {
                $this->insert(array(
                    'name'  =>  'theme:' . $theme,
                    'value' =>  serialize($settings),
                    'user'  =>  0
                ));
            }
        }

        /** 设置高亮 */
        $this->widget('Widget_Notice')->highlight('theme-' . $theme);

        /** 提示信息 */
        $this->widget('Widget_Notice')->set(_t("外观设置已经保存"), 'success');

        /** 转向原页 */
        $this->response->redirect(Typecho_Common::url('options-theme.php', $this->options->adminUrl));
    }

    /**
     * 用自有函数处理配置信息
     *
     * @access public
     * @param array $settings 配置值
     * @param boolean $isInit 是否为初始化
     * @return boolean
     */
    public function configHandle(array $settings, $isInit)
    {
        if (function_exists('themeConfigHandle')) {
            themeConfigHandle($settings, $isInit);
            return true;
        }

        return false;
    }

    /**
     * 绑定动作
     *
     * @access public
     * @return void
     */
    public function action()
    {
        /** 需要管理员权限 */
        $this->user->pass('administrator');
        $this->security->protect();
        $this->on($this->request->is('change'))->changeTheme($this->request->filter('slug')->change);
        $this->on($this->request->is('edit&theme'))
            ->editThemeFile($this->request->filter('slug')->theme, $this->request->edit);
        $this->on($this->request->is('config'))->config($this->options->theme);
        $this->response->redirect($this->options->adminUrl);
    }
}
