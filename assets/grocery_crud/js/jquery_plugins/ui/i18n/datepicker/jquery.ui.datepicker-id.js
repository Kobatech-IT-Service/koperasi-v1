/* Indonesian initialisation for the jQuery UI date picker plugin. */
/* Written by Deden Fathurahman (dedenf@gmail.com). */
jQuery(function ($) {
  // Return today's date and time
  var currentTime = new Date();
  var minYear = currentTime.getFullYear() - 60;
  var year = currentTime.getFullYear() - 17;
  $.datepicker.regional["id"] = {
    closeText: "Tutup",
    prevText: "&#x3C;mundur",
    nextText: "maju&#x3E;",
    currentText: "hari ini",
    monthNames: [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus",
      "September",
      "Oktober",
      "Nopember",
      "Desember",
    ],
    monthNamesShort: [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "Mei",
      "Jun",
      "Jul",
      "Agus",
      "Sep",
      "Okt",
      "Nop",
      "Des",
    ],
    dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
    dayNamesShort: ["Min", "Sen", "Sel", "Rab", "kam", "Jum", "Sab"],
    dayNamesMin: ["Mg", "Sn", "Sl", "Rb", "Km", "jm", "Sb"],
    weekHeader: "Mg",
    dateFormat: "dd/mm/yy",
    firstDay: 0,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: "",
    yearRange: "1945:" + new Date().getFullYear(),
  };
  $.datepicker.setDefaults($.datepicker.regional["id"]);
});
