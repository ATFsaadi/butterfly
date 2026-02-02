<h3 class="section-title text-center mt-5">Gestion des Réservations</h3>

<!-- si aucune réservation -->
<div class="alert alert-info text-center mt-4 d-none">
  Aucune réservation pour le moment.
</div>

<!-- tableau des réservations -->
<table class="table table-bordered mt-4 align-middle">
  <thead>
    <tr>
      <th>#</th>
      <th>Client</th>
      <th>Destination</th>
      <th>Dates</th>
      <th>Voyageurs</th>
      <th>Total</th>
      <th>Statut</th>
      <th>Action</th>
    </tr>
  </thead>

  <tbody>

    <!-- réservation confirmée -->
    <tr>
      <td>1</td>
      <td>Dupont Jean</td>
      <td>Paris — France</td>
      <td>2026-02-10 → 2026-02-15</td>
      <td>2</td>
      <td><strong>800,00 €</strong></td>
      <td>
        <span class="badge bg-success">✅ Confirmée</span>
      </td>
      <td>
        <a href="#" class="btn btn-sm btn-outline-danger">
          Annuler
        </a>
      </td>
    </tr>

    <!-- réservation en attente -->
    <tr>
      <td>2</td>
      <td>Martin Sarah</td>
      <td>Barcelone — Espagne</td>
      <td>2026-03-01 → 2026-03-06</td>
      <td>1</td>
      <td><strong>297,50 €</strong></td>
      <td>
        <span class="badge bg-warning text-dark">⏳ En attente</span>
      </td>
      <td>
        <a href="#" class="btn btn-sm btn-success">
          Confirmer
        </a>
        <a href="#" class="btn btn-sm btn-outline-danger">
          Annuler
        </a>
      </td>
    </tr>

    <!-- réservation annulée -->
    <tr>
      <td>3</td>
      <td>Benali Youssef</td>
      <td>Marrakech — Maroc</td>
      <td>2026-01-20 → 2026-01-25</td>
      <td>3</td>
      <td><strong>1 260,00 €</strong></td>
      <td>
        <span class="badge bg-danger">⛔ Annulée</span>
      </td>
      <td>
        <a href="#" class="btn btn-sm btn-success">
          Confirmer
        </a>
      </td>
    </tr>

  </tbody>
</table>
