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
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($tournament['name']); ?></h5>
                        <p class="card-text">
                            <strong>Nom :</strong> <?= $tournament['name']; ?><br>
                            <strong>Jeu :</strong> <?= $tournament['game_name']; ?><br>
                            <strong>Nombre joueurs :</strong> <?= $tournament['nb_player']; ?><br>
                            <strong>Date Début :</strong> <?= $tournament['date_start']; ?><br>
                            <strong>Date Fin :</strong> <?= $tournament['date_end']; ?><br><br>
                            <button>S'inscrire</button>
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
