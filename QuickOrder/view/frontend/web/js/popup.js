
define([
    "jquery",
    'Magento_Ui/js/modal/modal',
], function ($, modal) {
    'use strict';
    $.widget('project.popupModal', {
        options: {
            productSku: ""
        },
        _create: function () {
            this._bind();
        },

        _bind: function () {
            var self = this;
            var productSku = self.options.productSku;
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: 'Quick Order',
                buttons: false
            };
            var popup = modal(options, $('.content-'+ productSku));
            $("#btn-btn-primary-"+ productSku).on("click",function(){
                $('.content-'+ productSku).modal('openModal');
            });
        }

    });
    return $.project.popupModal;
});
