<div class="row">
    <div class="col">
        <form action="<?= isset($tournament) ? base_url("/admin/tournament/update") : base_url("/admin/tournament/create") ?>" method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <?= isset($tournament) ? "Editer " . $tournament['name'] : "Créer un tournoi    " ?>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="tab-content border p-3">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="name" placeholder="Nom" value="<?= isset($tournament) ? esc($tournament['name']) : ""; ?>" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_game" class="form-label">Sélectionnez un jeu</label>
                            <select class="form-select" id="id_game" name="id_game" required>
                                <option value="">Sélectionnez un jeu</option>
                                <?php foreach ($games as $game): ?>
                                    <option value="<?= $game['id']; ?>"
                                        <?= isset($tournament) && $tournament['id_game'] == $game['id'] ? 'selected' : ''; ?>>
                                        <?= esc($game['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nb_player" class="form-label">Nombre de joueurs</label>
                            <input type="number" class="form-control" id="nb_player" placeholder="Nombre de joueurs" value="<?= isset($tournament) ? esc($tournament['nb_player']) : ""; ?>" name="nb_player" required>
                        </div>

                        <div class="mb-3">
                            <label for="date_start" class="form-label">Date de Début</label>
                            <input type="datetime-local" class="form-control" id="date_start" value="<?= isset($tournament) ? esc(date('Y-m-d\TH:i', strtotime($tournament['date_start']))) : ""; ?>" name="date_start" required>
                        </div>

                        <div class="mb-3">
                            <label for="date_end" class="form-label">Date de Fin</label>
                            <input type="datetime-local" class="form-control" id="date_end" value="<?= isset($tournament) ? esc(date('Y-m-d\TH:i', strtotime($tournament['date_end']))) : ""; ?>" name="date_end" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <?php if (isset($tournament)): ?>
                        <input type="hidden" name="id" value="<?= esc($tournament['id']); ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <?= isset($tournament) ? "Sauvegarder" : "Enregistrer" ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
