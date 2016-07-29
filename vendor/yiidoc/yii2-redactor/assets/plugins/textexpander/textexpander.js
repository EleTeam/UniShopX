if (!RedactorPlugins) var RedactorPlugins = {};

(function ($) {
    RedactorPlugins.textexpander = function () {
        return {
            init: function () {
                if (!this.opts.textexpander) return;

                this.$editor.on('keyup.redactor-limiter', $.proxy(function (e) {
                    var key = e.which;
                    if (key == this.keyCode.SPACE) {
                        var current = this.selection.getCurrent();
                        var cloned = $(current).clone();

                        var $div = $('<div>');
                        $div.html(cloned);

                        var text = $div.html();
                        $div.remove();

                        var len = this.opts.textexpander.length;
                        var replaced = 0;

                        for (var i = 0; i < len; i++) {
                            var re = new RegExp(this.opts.textexpander[i][0]);
                            if (text.search(re) != -1) {
                                replaced++;
                                text = text.replace(re, this.opts.textexpander[i][1]);

                                $div = $('<div>');
                                $div.html(text);
                                $div.append(this.selection.getMarker());

                                var html = $div.html().replace(/&nbsp;/, '');

                                $(current).replaceWith(html);
                                $div.remove();
                            }
                        }

                        if (replaced !== 0) {
                            this.selection.restore();
                        }
                    }


                }, this));

            }
        };
    };
})(jQuery);