jQuery.fn.extend({
    uploadPreview: function (opts) {
        var _self = this,
            _this = $(this);
        opts = jQuery.extend({
            showImgId: "showImgTagId",
            imgType: ["gif", "jpeg", "jpg", "bmp", "png"],
            label: "上传",
            btnClass : "",
            callback: function () {}
        }, opts || {});
        _self.getObjectURL = function (file) {
            var url = null;
            if (window.createObjectURL != undefined) {
                url = window.createObjectURL(file);
            } else if (window.URL != undefined) {
                url = window.URL.createObjectURL(file);
            } else if (window.webkitURL != undefined) {
                url = window.webkitURL.createObjectURL(file);
            }
            return url;
        };
        
        _this.css({
        	"cursor":"pointer",
        	"filter":"alpha(opacity=0)",
        	"-moz-opacity":"0",
        	"opacity":"0",
        	"position":"absolute",
        	"top":"0",
        	"left":"0",
        	"z-index":"2",
        	"height":"40px",
        	"direction":"ltr"
        });
        _this.parent().css({
        	"position":"relative"
        })
        
        _this.change(function () {
            if (this.value) {
                if (!RegExp("\.(" + opts.imgType.join("|") + ")$", "i").test(this.value.toLowerCase())) {
                    alert("选择文件错误,图片类型必须是" + opts.imgType.join("，") + "中的一种");
                    this.value = "";
                    return false;
                }
                if (/msie/.test(navigator.userAgent.toLowerCase())) {
                    try {
                        $("#" + opts.showImgId).attr('src', _self.getObjectURL(this.files[0]));
                    } catch (e) {
                        var src = "";
                        var obj = $("#" + opts.showImgId);
                        var div = obj.parent("div")[0];
                        _self.select();
                        if (top != self) {
                            window.parent.document.body.focus();
                        } else {
                            _self.blur();
                        }
                        src = document.selection.createRange().text;
                        document.selection.empty();
                        obj.hide();
                        obj.parent("div").css({
                            'filter': 'progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)'
                        });
                        div.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = src;
                    }
                } else {
                    $("#" + opts.showImgId).attr('src', _self.getObjectURL(this.files[0]));
                }
                opts.callback();
            }
        });
    }
});