// Datepicker : transforme les champs date en calendrier francais.
// calendrier
document.addEventListener("DOMContentLoaded", function () {
  // vérification librairie
  if (typeof flatpickr === "undefined") {
    return;
  }

  // langue française
  const langue = flatpickr.l10ns && flatpickr.l10ns.fr ? flatpickr.l10ns.fr : "default";

  // champs date
  flatpickr('input[type="date"]', {
    altInput: true,
    altFormat: "d/m/Y",
    dateFormat: "Y-m-d",
    locale: langue,
    disableMobile: true
  });
});
