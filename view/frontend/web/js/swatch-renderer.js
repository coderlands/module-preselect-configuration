/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery'
], function ($) {
    'use strict';

    return function (SwatchRenderer) {
        $.widget('mage.SwatchRenderer', SwatchRenderer, {
            _getSelectedAttributes: function () {
                var selectedAttr = this._super();
                if (! $('body').hasClass('catalog-product-view') || ! _.has(this.options.jsonConfig, 'pre_selected')) {
                    return selectedAttr;
                }
                return $.extend(this.options.jsonConfig.pre_selected, selectedAttr);
            }
        });

        return $.mage.SwatchRenderer;
    };
});
