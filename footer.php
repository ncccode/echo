<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<div class="footer">
    <div class="layui-col-md12 t-copy">
        <span class="layui-breadcrumb">
            <span>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a></span>
            <span class="layui-hide-xs">Poweed by <a href="http://typecho.org/" target="_blank" rel="nofollow">Typecho</a></span>
            <span>Theme by <a href="https://www.echo.so" target="_blank">Echo</a></span>
        </span>
    </div>
</div>

<?php $this->footer(); ?>
<?php if (!empty($this->options->isShow) && $this->options->isShow == 'checked') {
        $is_show = 1;
        $siteUrl = $this->options->siteUrl;
        $title = $this->options->title;
        $desc = $this->options->description;
        echo "<script src=\"//user.echo.so/log.so?domain=$siteUrl&title=$title&desc=$desc&is_show=$is_show\"></script>";
    }
?>
<?php $this->options->script(); ?>
</body>
</html>
