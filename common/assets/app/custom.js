/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

var project = project || {};
(function (window, $, Math, p) {
    "use strict";
    var $alert = $('.ajax-notification-alert');

    p.Queue = (function () {
        var Queue = function () {
            this.a = new Node(null);
            this.b = 0;
        };
        var Node = function (v) {
            this.prev = null;
            this.next = null;
            this.value = v;
        };
        Queue.prototype.getLength = function () {
            return this.b;
        };
        Queue.prototype.isEmpty = function () {
            return 0 === this.b;
        };
        Queue.prototype.enqueue = function (o) {
            var n = new Node(o);
            n.prev = this.a;
            this.a.next = n;
            this.b++;
            return this;
        };
        Queue.prototype.dequeue = function () {
            if (!this.isEmpty()) {
                var n = this.a.next;
                if (n.next) {
                    this.a.next = n.next;
                    n.next.prev = this.a;
                } else {
                    this.a.next = null;
                }
                this.b--;
                return n.value;
            } else {
                return null;
            }
        };
        Queue.prototype.peek = function () {
            if (this.isEmpty()) {
                throw {
                    "name": "EmptyQueueException"
                    , "message": "You can't peek at an empty queue"
                };
            }
            return this.a.next.value;
        };
        return Queue;
    })();

    /**
     * 
     * @param {string} url
     * @param {object} data
     * @param {function} callback
     * @returns {undefined}
     */
    p.serverCall = function (url, data, callback) {
        callback = (typeof callback === 'function') ? callback : function () {
        };
        $.post(url, data).done(function (_data) {
            callback(_data);
        }).fail(function () {
            callback({
                "result": false
                , "message": 'Ha ocurrido un error de conexión con el servidor.'
            });
        });
        return;
    };
    /**
     * 
     * @param {string} url
     * @param {object} data
     * @param {function} callback
     * @returns {undefined}
     */
    p.serverCallBoolean = function (url, data, callback) {
        p.serverCall(url, data, function (response) {
            if (response.result === false) {
                p.showAlert('danger', response.message);
                callback(false);
            } else {
                p.showAlert('success', response.message);
                callback(true);
            }
        });
    };
    /**
     * 
     * @param {string} type
     * @param {string} message
     * @returns {undefined}
     */
    p.showAlert = function (type, message) {
        $alert.attr('class', 'ajax-notification-alert alert-' + type);
        $alert.hide();
        $alert.text(message);
        $alert.fadeIn('slow', function () {
            setTimeout(function () {
                $alert.fadeOut(1000);
            }, 3000);
        });
        return;
    };

    $('.control.close-window a').on('click', function (e) {
        e.preventDefault();
        window.close();
    });

    $('a.open-window').on('click', function (e) {
        var $this;
        e.preventDefault();
        $this = $(this);
        window.open($this.attr('href'), $this.data('windowname'));
    });

    var verticalCenter = function () {
        var $this = $(this);
        var center = function () {
            var top = Math.round((parseInt($(window).height()) - parseInt($this.height())) / 2);
            $this.css('margin-top', top + 'px');
        };
        $(window).resize(function () {
            center();
        });
        center();
    };
    $.fn.verticalCenter = verticalCenter;
})(window, jQuery, Math, project);