<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php
    //栏目分类内容
    $column_text = '';
    $Category_List = $this->widget('Widget_Metas_Category_List');
    if($Category_List->have()){
        while($Category_List->next()){
            $column_text .= '<li class="layui-col-md12 layui-col-xs6"><a href="'.$Category_List->permalink.'"><i class="layui-icon">&#xe63c;</i> '.$Category_List->name.'<span class="layui-badge layui-bg-gray">'.$Category_List->count.'</span></a></li>';
        }
    }
?>

<?php
    //博主动态内容
    $dynamic_text = '';
    $db = Typecho_Db::get();
    $cid = $db->fetchRow($db->select('cid')->from('table.contents')->where('template = ? AND status = ?', 'mylife.php', 'publish'))['cid'];
    $comments = $db->fetchAll($db->select()->from('table.comments')->where('cid = ? AND status = ?', $cid, 'approved')->order('created', Typecho_Db::SORT_DESC));

    foreach($comments as $comment) {
        $dynamic_text .= '<li><span class="layui-badge-dot layui-bg-gray"></span><p>'.$comment['text'].'<small>'.date("Y年m月d日 H:i:s",$comment['created']).'</small></p></li>';
    }
?>

<?php
    //标签云内容
    $tags_text = '';
    $Tag_Cloud = $this->widget('Widget_Metas_Tag_Cloud', 'sort=rand()&ignoreZeroCount=1&limit=30');
    if($Tag_Cloud->have()){
        while($Tag_Cloud->next()){
            $tags_text .= '<a class="layui-btn layui-btn-xs layui-btn-primary" style="color: rgb('.rand(0, 255).','. rand(0,255).','. rand(0, 255).')" href="'.$Tag_Cloud->permalink.'" title="'.$Tag_Cloud->name.'">'.$Tag_Cloud->name.'</a>';
        }
    }
?>

<?php $adsText = $this->options->adsText?$this->options->adsText:'广而告之'; ?>

<?php
$component =<<<HTML
    <div class="component layui-hide-xs">
        <form class="layui-form" id="search" method="post" action="{$this->options->siteUrl}" role="search">
            <div class="layui-inline input">
                <input type="text" id="s" name="s" class="layui-input" required lay-verify="required" autocomplete="off" placeholder="输入关键字搜索" />
            </div>
            <div class="layui-inline">
                <button class="layui-btn layui-btn-sm layui-btn-primary"><i class="layui-icon">&#xe615;</i></button>
            </div>
        </form>
    </div>
HTML;

$column =<<<HTML
    <div class="column">
        <h3 class="title-sidebar"><i class="layui-icon">&#xe705;</i> 栏目分类</h3>
        <ul class="layui-row layui-col-space5">
            {$column_text}
        </ul>
    </div>
HTML;

$ads =<<<HTML
    <div class="ads">
        <h3 class="title-sidebar"><i class="layui-icon">&#xe645;</i>{$adsText}</h3>
        <div>
            {$this->options->ads}
        </div>
    </div>
HTML;

$dynamic =<<<HTML
    <div class="dynamic">
        <h3 class="title-sidebar"><i class="layui-icon">&#xe60c;</i>博主动态 ~ </h3>
        <ul>
            {$dynamic_text}
        </ul>
    </div>
HTML;

$tags =<<<HTML
    <div class="tags">
        <h3 class="title-sidebar"><i class="layui-icon">&#xe66e;</i>标签云</h3>
        <div>
            {$tags_text}
        </div>
    </div>
HTML;

$link =<<<HTML
   <div class="link">
        <h3 class="title-sidebar"><i class="layui-icon">&#xe64c;</i>友情链接<a style="float: right;color: #666;" href="{$this->options->linksUrl}">{$this->options->linksText}</a></h3>
        <div>
            {$this->options->links}
        </div>
    </div>
HTML;
?>
<div class="sidebar layui-col-md3 layui-col-lg3">
    <?php if (!empty($this->options->sidebar)): ?>
        <?php
            $sidebar = explode(",",$this->options->sidebar);
            foreach($sidebar as $v) {
                switch ($v) {
                    case "1":
                        echo $component;
                        break;
                    case "2":
                        echo $column;
                        break;
                    case "3":
                        echo $ads;
                        break;
                    case "4":
                        echo $dynamic;
                        break;
                    case "5":
                        echo $tags;
                        break;
                    case "6":
                        echo $link;
                        break;
                    default:
                        echo "";
                 }
            }
        ?>
    <?php endif; ?>
</div>
