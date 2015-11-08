var app = app || {};

$(function () {
    'use strict';

    _.template.formatDateRFC3339 = function (iso) {
        var d = new Date(iso);

        return d.getUTCFullYear() + '-'
            + _.template.pad(d.getUTCMonth() + 1) + '-'
            + _.template.pad(d.getUTCDate()) + 'T'
            + _.template.pad(d.getUTCHours()) + ':'
            + _.template.pad(d.getUTCMinutes()) + ':'
            + _.template.pad(d.getUTCSeconds()) + 'Z';
    };

    _.template.formatDateShort = function (iso) {
        var d = new Date(iso);
        var fragments = [
            _.template.pad(d.getDate()),
            _.template.pad(d.getMonth() + 1),
            d.getFullYear()
        ];

        return fragments.join('-');
    };

    _.template.pad = function (n) {
        return n < 10 ? '0' + n : n
    };
});