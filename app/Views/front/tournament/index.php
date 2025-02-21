    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Jeux</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Liste des Tournois</h1>
            <div class="row">
                <?php foreach ($tournaments as $tournament): ?>
                    <input type="hidden" name="id_tournament" value="<?= $tournament['id']; ?>">
                    <input type="hidden" name="id_user" value="<?= ($user->id); ?>">
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($tournament['name']); ?></h5>
                                <p class="card-text">
                                    <strong>Nom :</strong> <?= $tournament['name']; ?><br>
                                    <strong>Jeu :</strong> <?= $tournament['game_name']; ?><br>
                                    <strong>Nombre joueurs :</strong> <?= $tournament['nb_player']; ?><br>
                                    <strong>Date Début :</strong> <?= $tournament['date_start'] ? date('d/m/Y H:i', strtotime($tournament['date_start'])) : ''; ?><br>
                                    <strong>Date Fin :</strong> <?= $tournament['date_end'] ? date('d/m/Y H:i', strtotime($tournament['date_end'])) : ''; ?><br><br>
                                    <?php
                                    // Vérifier si l'utilisateur est inscrit
                                    $isRegistered = false;
                                    foreach ($participants as $participant) {
                                        if ($participant['id_tournament'] == $tournament['id'] && $participant['id_user'] == $user->id) {
                                            $isRegistered = true;
                                            break;
                                        }
                                    }
                                    ?>

                                    <?php if ($isRegistered): ?>
                                        <!-- Bouton de désinscription -->
                                        <a href="<?= base_url('/tournament/unregister?id_user=' . $user->id . '&id_tournament=' . $tournament['id']); ?>" class="btn btn-danger">
                                            Se désinscrire
                                        </a>
                                    <?php else: ?>
                                        <!-- Bouton d'inscription -->
                                        <a href="<?= base_url('/tournament/register?id_user=' . $user->id . '&id_tournament=' . $tournament['id']); ?>" class="btn btn-primary">
                                            S'inscrire
                                        </a>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
