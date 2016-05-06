define(
    [
        'jquery',
        'angular',
        'appModule'
    ],
    function ($, angular, app) {
        'use strict';
        return app.expansions = {
            convertToBase64: function (file,callback) {
                var FR = new FileReader();
                FR.readAsDataURL(file);
                FR.onload = function () {
                    callback(FR.result);
                }
            },
            checkResult:function (data) {
                var errors = [];
                $.each(data,function (key, value) {
                    if (typeof value != 'object') {
                        errors.push(value);
                    }
                });
                if(errors.length > 0) {
                    return errors;
                } else {
                    return true;
                }
            },
            notifications: function (messages) {
                var a = function () {
                    this.messages = this.prepare(messages);
                    return this;
                };
                a.prototype.dom = $('body');
                a.prototype.prepare = function (array) {
                    var arr = [];
                    $.each(array,function (key, item) {
                        arr.push($.parseJSON(item));
                    });
                    return arr;
                };
                a.prototype.show = function () {
                    this.dom.append('<div class="notification-bar"></div>');
                    $.each(this.messages,function (key, message) {
                        $('.notification-bar').append("<p>"+message.description+"</p>")
                    });
                };
                a.prototype.hide = function () {
                    $('.notification-bar').remove()
                };
                return new a;
            },
            backLight: function (form) {
                var c =function () {
                    this.form = form;
                    return this;
                };
                c.prototype.indicator = function () {
                    this.form.addClass('loading');
                };
                c.prototype.show = function (messages, css, callback) {
                    var that = this, msg = false, n;
                    if(messages.length > 0) {
                        msg = true;
                        n = app.expansions.notifications(messages);
                        n.show();
                    }
                    this.form.removeClass('loading').addClass(css);

                    if(callback) {
                        setTimeout(function(){
                            that.form.removeClass(css);
                            if(msg) {
                                n.hide();
                            }
                            callback();
                        },1000)
                    }
                };
                return new c;
            }
        };
    }
);