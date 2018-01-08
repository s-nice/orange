/**
 * ZXC utility functions
 *
 * namespace: ZXC.util
 * function: locate, copy
 */

ZXC.Namespace("ZXC.util");

// Load Image with a transition process animation.
ZXC.util.loadImage = function(elem, url, loadingImg) {
    if (elem.tagName.toLowerCase() != 'img') return;
    var inst = ZXC.util.loadImage;

    // already loaded
    inst.loaded = inst.loaded || {};
    if (inst.loaded[url]) {
        jQuery(elem).attr("src", url);
        return;
    }
    var oldbg = jQuery(elem).css("background");
    // create loader
    if (!elem.loader) {
        elem.loader = {
            loading:false, defH:0, defW:0, link:null,
            proxy:jQuery(document.createElement("img")).load(function() {
                var target = this.target;
                with(target.loader) {
                    inst.loaded[link] = true;
                    loading = false;
                    jQuery(target).height(defH).width(defW)
                        .css("background", oldbg)
                        .attr("src", link);
                }
            })
        };
        elem.loader.proxy[0].target = elem;
    }

    var newbg = loadingImg || JS_PUBLIC+"/images/mask_loading1.gif";
    with(elem.loader) {
        if (!loading) {
            defH = elem.style.height || jQuery(elem).height() || elem.height || "auto";

            defW = elem.style.width || jQuery(elem).width() || elem.width || "auto";
            jQuery(elem).height(defH)
                .width(defW)
                .css("background", "url(\"" + newbg + "\") no-repeat center center")
                .attr("src", JS_PUBLIC+"/images/mask_loading1.gif");
            loading = true;
        }
        link = url;
        jQuery(elem).attr("src", link);
    }
};
jQuery.fn.getImage = function(url) {
    if (this.length > 0)
        ZXC.util.loadImage(this[0], url);
    return this;
};

ZXC.util.bind = function(target, data, type, more)
{
    var mode = type;
    if (type != "eval" && type != "member")
        mode = "event";

    if (mode == "event") {
        var triggers = ("string" == typeof data) ? jQuery("[obj=" + data + "][op]") : jQuery("[op]", data);
        triggers.each(function() {
            var op = jQuery(this).attr("op");
            if (op.length == 0)
                return;
            op = [op, op + "Handler", "on" + op];
            for (var i = 0; i < op.length; i++) {
                if (target[op[i]] && "function" == typeof target[op[i]]) {
                    jQuery(this).bind(type, function(event) {
                        if (!event.currentTarget)
                            event.currentTarget = this;
                        event.data = more;
                        if (more && "function" == typeof more)
                            event.data = more(this);
                        target[op[i]](event);
                    });
                    break;
                }
            }
        });
    }
    else if (mode == "member") {
        var infos = ("string" == typeof data) ? jQuery("[obj=" + data + "][var]") : jQuery("[var]", data);
        infos.each(function() {
            var member = jQuery(this).attr("var");
            target[member] = this;
        });
    }
    else {
        jQuery("[mark]", jQuery(target)).each(function() {
            var marks = jQuery(this).attr("mark");
            marks = marks.split(",");
            for (var i = 0; i < marks.length; i++) {
                var mark = marks[i];

                var is_attr = false;
                if (mark.charAt(0) == "@") {
                    is_attr = true;
                    mark = mark.substring(1);
                }
                if (data[mark] === undefined) {
                    continue;
                }
                var tagname = this.tagName;
                switch(tagname) {
                    case 'INPUT':
                        if (this.type == "radio" || this.type == "checkbox") {
                            if (this.value == data[mark]) {
                                this.checked = true;
                            }
                            break;
                        }
                    case 'TEXTAREA':
                    case 'SELECT':
                        jQuery(this).val(data[mark].toString());break;
                    case 'IMG':
                    	//if(data[mark] == null || data[mark] == undefined || data[mark] == 0) break;
                        if(data[mark].toString() == "0" || typeof(data[mark].toString())=="undefined"){
                            data[mark] = js_context.res_url.get("images/avatar120.gif");
                        }
                        jQuery(this).getImage(data[mark].toString());break;
                        //jQuery(this).attr('src',data[mark].toString());break;
                    default:
                        if (data[mark] === null){
                            throw new Error('[mark='+mark+'] is NULL');
                        }
                        else if ("object" == typeof data[mark]) {
                            if (data[mark][0] !== undefined) {
                                if('function' == typeof data[mark][0].toString){
                                    jQuery(this).html(data[mark][0].toString());
                                }else{
                                    jQuery(this).html('');
                                }
                            }
                            for (var key in data[mark]) {
                                if (jQuery(this).attr(key) !== undefined) {
                                    jQuery(this).attr(key, data[mark][key]);
                                }
                            }
                        }
                        else {
                            if (is_attr) {
                                jQuery(this).attr(mark, data[mark].toString());
                            }
                            else {
                                jQuery(this).html(data[mark].toString());
                            }
                        }
                }
            } // end of for each mark
        });
    }
};
