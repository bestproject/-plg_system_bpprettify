import 'code-prettify/src/prettify';

$.fn.BPPrettify = (lines = false) => {
    let $list = $("code,pre,xmp");

    if ($list.length) {
        $list.each(function (idx, el) {
            if ($(el).parent("pre,code").length === 0) {
                $(el).addClass("prettyprint" + (lines ? ' linenums' : ''));
            }
        });

        prettyPrint();
    }
};