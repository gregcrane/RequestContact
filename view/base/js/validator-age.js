/**
 * @copyright   Copyright © Leviathan Studios, Licensed under MIT
 * @author      Grey Crane <gmc31886@gmail.com>
 */

define([
'jquery'
], function ($) {
    "use strict";

    return function () {
        $.validator.addMethod(
            'validate-minimum-age',
            function (value, params) {
                return (value >= params.minimum_age);
            },
            $.mage.__('You must be over %1 years old.').replace('%1', params.minimum_age)
        );
    }
});
