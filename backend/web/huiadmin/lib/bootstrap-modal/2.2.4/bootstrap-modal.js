/* ===========================================================
 * bootstrap-modal.js v2.2.4
 * ===========================================================
 * Copyright 2012 Jordan Schroter
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */
!function($) {
    "use strict";
    var Modal = function(element, options) {
        this.init(element, options);
    };
    Modal.prototype = {
        constructor: Modal,
        init: function(element, options) {
            var that = this;
            this.options = options;
            this.$element = $(element).delegate('[data-dismiss="modal"]', 'click.dismiss.modal', $.proxy(this.hide, this));
            this.options.remote && this.$element.find('.modal-body').load(this.options.remote,
            function() {
                var e = $.Event('loaded');
                that.$element.trigger(e);
            });

            var manager = typeof this.options.manager === 'function' ? this.options.manager.call(this) : this.options.manager;
            manager = manager.appendModal ? manager: $(manager).modalmanager().data('modalmanager');
            manager.appendModal(this);
        },
        toggle: function() {
            return this[!this.isShown ? 'show': 'hide']();
        },

        show: function() {
            var e = $.Event('show');
            if (this.isShown) return;
            this.$element.trigger(e);
            if (e.isDefaultPrevented()) return;
            this.escape();
            this.tab();
            this.options.loading && this.loading();
        },

        hide: function(e) {
            e && e.preventDefault();
            e = $.Event('hide');
            this.$element.trigger(e);
            if (!this.isShown || e.isDefaultPrevented()) return (this.isShown = false);
            this.isShown = false;
            this.escape();
            this.tab();
            this.isLoading && this.loading();
            $(document).off('focusin.modal');
            this.$element.removeClass('in').removeClass('animated').removeClass(this.options.attentionAnimation).removeClass('modal-overflow').attr('aria-hidden', true);

            $.support.transition && this.$element.hasClass('fade') ? this.hideWithTransition() : this.hideModal();
        },

        layout: function() {
            var prop = this.options.height ? 'height': 'max-height',
            value = this.options.height || this.options.maxHeight;
            if (this.options.width) {
                this.$element.css('width', this.options.width);
                var that = this;
                this.$element.css('margin-left',
                function() {
                    if (/%/ig.test(that.options.width)) {
                        return - (parseInt(that.options.width) / 2) + '%';
                    } else {
                        return - ($(this).width() / 2) + 'px';
                    }
                });
            } else {
                this.$element.css('width', '');
                this.$element.css('margin-left', '');
            }

            this.$element.find('.modal-body').css('overflow', '').css(prop, '');

            if (value) {
                this.$element.find('.modal-body').css('overflow', 'auto').css(prop, value);
            }

            var modalOverflow = $(window).height() - 10 < this.$element.height();
			

            if (modalOverflow || this.options.modalOverflow) {
                this.$element.css('margin-top', 0).addClass('modal-overflow');
            } else {
                this.$element
                .css('margin-top', 0 - this.$element.height() / 2)
                .removeClass('modal-overflow');
            }
        },

        tab: function() {
            var that = this;
            if (this.isShown && this.options.consumeTab) {
                this.$element.on('keydown.tabindex.modal', '[data-tabindex]',
                function(e) {
                    if (e.keyCode && e.keyCode == 9) {
                        var $next = $(this),
                        $rollover = $(this);
                        that.$element.find('[data-tabindex]:enabled:not([readonly])').each(function(e) {
                            if (!e.shiftKey) {
                                $next = $next.data('tabindex') < $(this).data('tabindex') ? $next = $(this) : $rollover = $(this);
                            } else {
                                $next = $next.data('tabindex') > $(this).data('tabindex') ? $next = $(this) : $rollover = $(this);
                            }
                        });

                        $next[0] !== $(this)[0] ? $next.focus() : $rollover.focus();
                        e.preventDefault();
                    }
                });
            } else if (!this.isShown) {
                this.$element.off('keydown.tabindex.modal');
            }
        },

        escape: function() {
            var that = this;
            if (this.isShown && this.options.keyboard) {
                if (!this.$element.attr('tabindex')) this.$element.attr('tabindex', -1);

                this.$element.on('keyup.dismiss.modal',
                function(e) {
                    e.which == 27 && that.hide();
                });
            } else if (!this.isShown) {
                this.$element.off('keyup.dismiss.modal')
            }
        },

        hideWithTransition: function() {
            var that = this,
            timeout = setTimeout(function() {
                that.$element.off($.support.transition.end);
                that.hideModal();
            },
            500);

            this.$element.one($.support.transition.end,
            function() {
                clearTimeout(timeout);
                that.hideModal();
            });
        },

        hideModal: function() {
            var prop = this.options.height ? 'height': 'max-height';
            var value = this.options.height || this.options.maxHeight;

            if (value) {
                this.$element.find('.modal-body').css('overflow', '').css(prop, '');
            }

            this.$element.hide().trigger('hidden');
        },

        removeLoading: function() {
            this.$loading.remove();
            this.$loading = null;
            this.isLoading = false;
        },

        loading: function(callback) {
            callback = callback ||
            function() {};

            var animate = this.$element.hasClass('fade') ? 'fade': '';

            if (!this.isLoading) {
                var doAnimate = $.support.transition && animate;

                this.$loading = $('<div class="loading-mask ' + animate + '">').append(this.options.spinner).appendTo(this.$element);

                if (doAnimate) this.$loading[0].offsetWidth;
                /*force reflow*/

                this.$loading.addClass('in');

                this.isLoading = true;

                doAnimate ? this.$loading.one($.support.transition.end, callback) : callback();

            } else if (this.isLoading && this.$loading) {
                this.$loading.removeClass('in');

                var that = this;
                $.support.transition && this.$element.hasClass('fade') ? this.$loading.one($.support.transition.end,
                function() {
                    that.removeLoading()
                }) : that.removeLoading();

            } else if (callback) {
                callback(this.isLoading);
            }
        },

        focus: function() {
            var $focusElem = this.$element.find(this.options.focusOn);
            $focusElem = $focusElem.length ? $focusElem: this.$element;
            $focusElem.focus();
        },

        attention: function() {
            /*NOTE: transitionEnd with keyframes causes odd behaviour*/

            if (this.options.attentionAnimation) {
                this.$element.removeClass('animated').removeClass(this.options.attentionAnimation);

                var that = this;

                setTimeout(function() {
                    that.$element.addClass('animated').addClass(that.options.attentionAnimation);
                },
                0);
            }
            this.focus();
        },

        destroy: function() {
            var e = $.Event('destroy');
            this.$element.trigger(e);
            if (e.isDefaultPrevented()) return;
            this.$element.off('.modal').removeData('modal').removeClass('in').attr('aria-hidden', true);

            if (this.$parent !== this.$element.parent()) {
                this.$element.appendTo(this.$parent);
            } else if (!this.$parent.length) {
                // modal is not part of the DOM so remove it.
                this.$element.remove();
                this.$element = null;
            }
            this.$element.trigger('destroyed');
        }
    };

    $.fn.modal = function(option, args) {
        return this.each(function() {
            var $this = $(this),
            data = $this.data('modal'),
            options = $.extend({},
            $.fn.modal.defaults, $this.data(), typeof option == 'object' && option);

            if (!data) $this.data('modal', (data = new Modal(this, options)));
            if (typeof option == 'string') data[option].apply(data, [].concat(args));
            else if (options.show) data.show()
        })
    };

    $.fn.modal.defaults = {
        keyboard: true,
        backdrop: true,
        loading: false,
        show: true,
        width: null,
        height: null,
        maxHeight: null,
        modalOverflow: false,
        consumeTab: true,
        focusOn: null,
        replace: false,
        resize: false,
        attentionAnimation: 'shake',
        manager: 'body',
        spinner: '<div class="loading-spinner" style="width:32px;margin-left:-16px;"><img src="data:image/gif;base64,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"></div></div>',
        backdropTemplate: '<div class="modal-backdrop" />'
    };

    $.fn.modal.Constructor = Modal;

    $(function() {
        $(document).off('click.modal').on('click.modal.data-api', '[data-toggle="modal"]',
        function(e) {
            var $this = $(this),
            href = $this.attr('href'),
            $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))),
            //strip for ie7
            option = $target.data('modal') ? 'toggle': $.extend({
                remote: !/#/.test(href) && href
            },
            $target.data(), $this.data());

            e.preventDefault();
            $target.modal(option).one('hide',
            function() {
                $this.focus();
            })
        });
    });
} (window.jQuery);

$(".modal").resize(function(){var modal_h=$(".modal").height();var windows_h=$(window).width();if(modal_h>=windows_h){$(this).addClass("modal-overflow modal-overflow2");return;}
  else{$(this).removeClass("modal-overflow modal-overflow2");}});