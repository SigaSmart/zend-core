$.AdminLTE = {
    base: $("link[rel='base']").attr("href")
};
/* --------------------
 * - AdminLTE Options -
 * --------------------
 * Modify these options to suit your implementation
 */
$.AdminLTE.options = {
    obj:null,
    beforeSend: function () {
        $('.body-processing').fadeIn(100, function () {
            $('.processing').fadeIn();
        });
    },
    success: function (data) {
        this.obj.html(data);
    },
    error: function (data) {},
    complete: function () {
        $('form[name="AjaxForm"]').ajaxForm($.AdminLTE.form);
        $('.body-processing').fadeOut(100, function () {
            $('.processing').fadeOut();
        });
    },
    dataType: 'html'
};
$.AdminLTE.form = {
    beforeSubmit: showRequest, // pre-submit callback
    success: showResponse, // post-submit callback
    type: 'post', // 'get' or 'post', override for form's 'method' attribute
    dataType: 'html' // 'xml', 'script', or 'json' (expected server response type)
};

(function (jQuery) {
    $.AdminLTE.options.beforeSend();
    jQuery.fn.zfForm = function (url, options) {
        var initialized = false;
        var options = $.extend($.AdminLTE.options, options);
        function strip(html) {
            var tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        }

        function init($obj) {
            //options.onInit();
            ajax($obj);
        }
        function ajax() {
            jQuery.ajax({
                url: url,
                beforeSend: function (e) {
                    options.beforeSend(e)
                },
                success: function (data) {
                    options.success(data);
                },
                error: function (e) {
                    options.error();
                },
                complete: function (data) {
                    options.complete(data);
                },
                dataType: options.dataType
            });

        }
        return this.each(function () {
            var $this = jQuery(this);
            if (!initialized) {
                $.AdminLTE.options.obj = $this;
                init();
            }

        });
    };
})(jQuery);

// pre-submit callback
function showRequest(formData, jqForm, options) {
    $('.body-processing').fadeIn(100, function () {
        $('.processing').fadeIn();
    });
    return true;
}

// post-submit callback
function showResponse(responseText, statusText, xhr, $form) {
    $.AdminLTE.options.obj.html(responseText);
    $.AdminLTE.options.complete();
}