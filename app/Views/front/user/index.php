<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Espace Utilisateur</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/user/profile"><i class="bi bi-person-circle"></i> Mon Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/catalog"><i class="bi bi-list"></i> Catalogue</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/orders"><i class="bi bi-box"></i> Mes Commandes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Welcome Section -->
<div class="container text-center my-5">
    <h1>Bienvenue, [Nom d'utilisateur]!</h1>
    <p class="text-muted">Accédez à vos commandes, parcourez notre catalogue ou gérez votre profil.</p>
</div>

<!-- Action Cards -->
<div class="container">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle display-4 text-primary"></i>
                    <h5 class="card-title mt-3">Mon Profil</h5>
                    <p class="card-text">Consultez ou modifiez vos informations personnelles.</p>
                    <a href="/user/profile" class="btn btn-primary">Voir Profil</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-list display-4 text-primary"></i>
                    <h5 class="card-title mt-3">Catalogue</h5>
                    <p class="card-text">Découvrez nos produits et services disponibles.</p>
                    <a href="/user/catalog" class="btn btn-primary">Explorer</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-box display-4 text-primary"></i>
                    <h5 class="card-title mt-3">Mes Commandes</h5>
                    <p class="card-text">Accédez à l'historique de vos commandes passées.</p>
                    <a href="/user/orders" class="btn btn-primary">Voir Commandes</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-3 mt-5">
    <p>&copy; 2024 Votre Site. Tous droits réservés.</p>
</footer>

<!-- Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
</body>
</html>
