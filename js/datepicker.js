// calendrier
document.addEventListener("DOMContentLoaded", function () {
  if (typeof flatpickr === "undefined") {
    return;
  }

  const langue = flatpickr.l10ns && flatpickr.l10ns.fr ? flatpickr.l10ns.fr : "default";

  flatpickr('input[type="date"]', {
    altInput: true,
    altFormat: "d/m/Y",
    dateFormat: "Y-m-d",
    locale: langue,
    disableMobile: true
  });
});
