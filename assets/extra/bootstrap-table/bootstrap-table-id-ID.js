/**
 * Bootstrap Table English translation
 * Author: Zhixin Wen<wenzhixin2010@gmail.com>
 */
(function ($) {
    'use strict';

    $.fn.bootstrapTable.locales['id-ID'] = {
        formatLoadingMessage: function () {
            return 'Sedang memuat...';
        },
        formatRecordsPerPage: function (pageNumber) {
            return pageNumber + ' data per halaman';
        },
        formatShowingRows: function (pageFrom, pageTo, totalRows) {
            return pageFrom + ' - ' + pageTo + ' dari total ' + totalRows + ' data';
        },
        formatSearch: function () {
            return 'Cari';
        },
        formatNoMatches: function () {
            return 'Tidak ada data';
        },
        formatPaginationSwitch: function () {
            return 'Tampil/Sembunyi Navigasi Halaman';
        },
        formatRefresh: function () {
            return 'Refresh';
        },
        formatToggle: function () {
            return 'Toggle';
        },
        formatColumns: function () {
            return 'Kolom';
        },
        formatAllRows: function () {
            return 'Semua';
        }
    };

    $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales['id-ID']);

})(jQuery);