<div class="row">
    <div class="col">
        <form action="<?= isset($schools) ? base_url("/admin/school/update") : base_url("/admin/school/create") ?>" method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <?= isset($schools) ? "Editer " . $schools['name'] : "Créer une Ecole" ?>
                    </h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil" type="button" role="tab" aria-controls="profil" aria-selected="true">Profil</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="onglet-tab" data-bs-toggle="tab"
                                    data-bs-target="#onglet" type="button" role="tab" aria-controls="onglet"
                                    aria-selected="false">ONGLET</button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content border p-3">
                        <div class="tab-pane active" id="profil" role="tabpanel" aria-labelledby="profil-tab" tabindex="0">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="name" placeholder="Nom"
                                       value="<?= isset($schools) ? $schools['name'] : ""; ?>" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">Ville</label>
                                <input type="text" class="form-control" id="city" placeholder="Ville"
                                       value="<?= isset($schools) ? $schools['city'] : ""; ?>" name="city">
                            </div>
                            <label for="category" class="form-label">Catégorie</label>
                            <select class="form-select" name="id_category" required>
                                <option value="">Sélectionnez une catégorie</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?=$category['id'] ?>"><?= $category['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="tab-pane" id="onglet" role="tabpanel" aria-labelledby="onglet-tab" tabindex="0">

                        </div>

                    </div>
                </div>

                <div class="card-footer text-end">
                    <?php if (isset($schools)): ?>
                        <input type="hidden" name="id" value="<?= $schools['id']; ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <?= isset($schools) ? "Sauvegarder" : "Enregistrer" ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>