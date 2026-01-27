document.addEventListener("DOMContentLoaded", () => {

  if (typeof flatpickr === "undefined") {
    console.error("flatpickr non chargé");
    return;
  }

  const today = new Date();

  /* helpers */
  const setupFlatpickrPair = (startInput, endInput) => {
    if (!startInput || !endInput) return;

    const endPicker = flatpickr(endInput, {
      dateFormat: "Y-m-d",
      minDate: today,
      allowInput: false,
      disableMobile: true,
      locale: (flatpickr.l10ns && flatpickr.l10ns.fr) ? "fr" : undefined
    });

    flatpickr(startInput, {
      dateFormat: "Y-m-d",
      minDate: today,
      defaultDate: startInput.value || today,
      allowInput: false,
      disableMobile: true,
      locale: (flatpickr.l10ns && flatpickr.l10ns.fr) ? "fr" : undefined,
      onChange: function (selectedDates, dateStr) {
        endPicker.set("minDate", dateStr);
        if (!endInput.value || endInput.value < dateStr) {
          endPicker.setDate(dateStr, true);
        }
      }
    });

    if (!endInput.value || (startInput.value && endInput.value < startInput.value)) {
      endPicker.set("minDate", startInput.value || today);
      endPicker.setDate(startInput.value || today, true);
    } else {
      endPicker.set("minDate", startInput.value || today);
    }
  };

  /* 1) ADMIN (par name) */
  const adminPairs = [
    { start: 'date_depart', end: 'date_retour' },
    { start: 'date_debut', end: 'date_fin' }
  ];

  adminPairs.forEach(pair => {
    const startInput = document.querySelector(`input[name="${pair.start}"]`);
    const endInput   = document.querySelector(`input[name="${pair.end}"]`);
    setupFlatpickrPair(startInput, endInput);
  });

  /* 2) MENU VOYAGE (par id) */
  const menuPairs = [
    { startId: 'dateDepart', endId: 'dateArrivee' },
    { startId: 'dateDepartMobile', endId: 'dateArriveeMobile' }
  ];

  menuPairs.forEach(pair => {
    const startInput = document.getElementById(pair.startId);
    const endInput   = document.getElementById(pair.endId);
    setupFlatpickrPair(startInput, endInput);
  });

});
