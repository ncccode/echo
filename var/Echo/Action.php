<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Echo_Action extends Typecho_Widget implements Widget_Interface_Do
{
    private $db;
    private $prefix;
    private $options;

    public function __construct($request, $response, $params = NULL)
    {
        parent::__construct($request, $response, $params);
        /** 需要管理员权限 */
        $this->widget('Widget_User')->pass('administrator');
        $this->db = Typecho_Db::get();
        $this->prefix = $this->db->getPrefix();
        $this->options = Typecho_Widget::widget('Widget_Options');
    }

    public function setting()
    {
        $data = $this->request->from(
            'logoUrl',
            'title',
            'nav',
            'navFixed',
            'headerColor',
            'headerTextColor',
            'footerColor',
            'footerTextColor',
            'backgroundColor',
            'backgroundImg',
            'sidebar'
        );
        $this->options($data);
    }

    public function config()
    {
        $data = $this->request->from(
            'codeStyle',
            'gravatar',
            'bigCarouselSwitch',
            'bigCarouselHeight',
            'bigCarouselText',
            'smallCarouselSwitch',
            'smallCarouselHeight',
            'smallCarouselText',
            'thumbType',
            'thumbs',
            'adsText',
            'ads',
            'linksText',
            'linksUrl',
            'links',
            'mylifeName',
            'mylifeJob',
            'mylifeAvatar',
            'mylifeDesc',
            'mylifeBtn',
            'script'
        );
        $this->options($data);
    }


    public function options($data)
    {
        $settings = $this->options->__get('theme:echo');
        if ($settings) {
            $settings = unserialize($settings);
            foreach ($settings as $key => $value) {
                if(!in_array($key,array_keys($data))){
                    $data[$key] = $value;
                }
            }
            $res = $this->db->query($this->db->update('table.options')->rows(array('value' =>  serialize($data)))->where('name = ?', 'theme:echo'));
        } else {
            $res = $this->db->query($this->db->insert('table.options')->rows(array(
                'name'  =>  'theme:echo',
                'value' =>  serialize($data),
                'user'  =>  0
            )));
        }
        if ($res || $res===0) {
            $result = array('status' => 1, 'msg' => _t('设置成功'));
        } else {
            $result = array('status' => 0, 'msg' => _t('设置失败'));
        }

        $this->response->throwJson($result);
    }

    public function action()
    {
        $this->on($this->request->is('do=setting'))->setting();
        $this->on($this->request->is('do=config'))->config();
        $this->response->redirect($this->options->adminUrl);
    }
}
?>
