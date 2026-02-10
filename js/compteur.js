(() => {
  // Destination
  const d1 = document.getElementById("date_depart"),
    d2 = document.getElementById("date_retour"),
    nb = document.getElementById("nb_personnes"),
    nN = document.getElementById("dest_nb_nuits"),
    nP = document.getElementById("dest_nb_personnes"),
    totD = document.getElementById("dest_total"),
    err = document.getElementById("dest_err_date"),
    btnD = document.getElementById("btn_confirm_dest"),
    cfgD = document.getElementById("js_dest");

  if (d1 && d2 && nb && nN && nP && totD && btnD && cfgD) {
    const pu = Number(cfgD.dataset.prixUnitaire || "0");
    const fmt = new Intl.NumberFormat("fr-FR", { style: "currency", currency: "EUR" });

    const upd = () => {
      const p = Math.max(1, parseInt(nb.value || "1", 10));
      nb.value = p;
      nP.textContent = p;

      const t1 = Date.parse(d1.value),
        t2 = Date.parse(d2.value);

      let nuits = 1,
        bad = false;

      if (Number.isFinite(t1) && Number.isFinite(t2)) {
        const diff = Math.floor((t2 - t1) / 86400000);
        bad = diff < 0;
        nuits = diff <= 0 ? 1 : diff;
      }

      nN.textContent = nuits;
      totD.textContent = fmt.format(pu * p * nuits);

      if (err) err.classList.toggle("d-none", !bad);
      btnD.disabled = bad;
    };

    ["input", "change"].forEach((e) => {
      d1.addEventListener(e, upd);
      d2.addEventListener(e, upd);
      nb.addEventListener(e, upd);
    });

    upd();
  }

  // Voyage
  const nbV = document.getElementById("voyage_nb_personnes"),
    totV = document.getElementById("voyage_total"),
    cfgV = document.getElementById("js_voyage");

  if (nbV && totV && cfgV) {
    const puV = Number(cfgV.dataset.prixUnitaire || "0");
    const fmtV = new Intl.NumberFormat("fr-FR", { style: "currency", currency: "EUR" });

    const updV = () => {
      const p = Math.max(1, parseInt(nbV.value || "1", 10));
      nbV.value = p;
      totV.textContent = fmtV.format(puV * p);
    };

    ["input", "change"].forEach((e) => nbV.addEventListener(e, updV));
    updV();
  }
})();
