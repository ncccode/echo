$(function() {
    $('#text').before('<div id="vditor"></div>');
    $('#text').hide();
    $('.typecho-post-area .resize').hide();
    $('#btn-cancel-preview').remove();
    $('#btn-preview').remove();
    var vditor = new Vditor("vditor", {
        height: document.documentElement.clientHeight * 0.6,
        typewriterMode: true,
        cache: {
            enable: false,
            cid: $('input[name="cid"]').val()
        },
        value: $('#text').text(),
        mode: 'sv',
        preview: {
            mode: "both",
            actions: [],
            theme: {
                current: "light",
            }
        },
        counter: {
            enable: true
        },
        toolbarConfig: {
            pin: true
        },
        resize: {
            enable: true,
            position: "bottom"
        }
    });
    // 保存前保存数据到 #text
    $('#text').parents().find('form').on('submit', function () {
        $('#text').val(vditor.getValue());
        return true;
    });
});
