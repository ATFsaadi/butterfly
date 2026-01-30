document.addEventListener("DOMContentLoaded", () => {

  /* sécurité : flatpickr chargé ? */
  if (typeof flatpickr === "undefined") {
    console.error("flatpickr non chargé");
    return;
  }

  const today = new Date();

  /* helper : lie 2 champs date */
  function setupFlatpickrPair(startInput, endInput) {
    if (!startInput || !endInput) return;

    /* date de fin */
    const endPicker = flatpickr(endInput, {
      dateFormat: "Y-m-d",
      minDate: today,
      allowInput: false,
      disableMobile: true,
      locale: (flatpickr.l10ns?.fr) ? "fr" : undefined
    });

    /* date de début */
    flatpickr(startInput, {
      dateFormat: "Y-m-d",
      minDate: today,
      defaultDate: startInput.value || today,
      allowInput: false,
      disableMobile: true,
      locale: (flatpickr.l10ns?.fr) ? "fr" : undefined,

      onChange(selectedDates, dateStr) {
        endPicker.set("minDate", dateStr);

        /* force date fin >= date début */
        if (!endInput.value || endInput.value < dateStr) {
          endPicker.setDate(dateStr, true);
        }
      }
    });

    /* initialisation cohérente */
    const startVal = startInput.value || today;
    if (!endInput.value || endInput.value < startVal) {
      endPicker.set("minDate", startVal);
      endPicker.setDate(startVal, true);
    } else {
      endPicker.set("minDate", startVal);
    }
  }

  /* admin (par name) */
  [
    { start: "date_depart", end: "date_retour" },
    { start: "date_debut", end: "date_fin" }
  ].forEach(({ start, end }) => {
    setupFlatpickrPair(
      document.querySelector(`input[name="${start}"]`),
      document.querySelector(`input[name="${end}"]`)
    );
  });

  /* menu voyage (par id) */
  [
    { start: "dateDepart", end: "dateArrivee" },
    { start: "dateDepartMobile", end: "dateArriveeMobile" }
  ].forEach(({ start, end }) => {
    setupFlatpickrPair(
      document.getElementById(start),
      document.getElementById(end)
    );
  });

});
