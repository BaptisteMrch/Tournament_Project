<div class="row">
    <div class="col">
        <form action="<?= isset($games) ? base_url("/admin/game/update") : base_url("/admin/game/create") ?>" method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <?= isset($games) ? "Editer " . $games['name'] : "Créer un Jeu    " ?>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="tab-content border p-3">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="name" placeholder="Nom" value="<?= isset($games) ? $games['name'] : ""; ?>" name="name">
                        </div>

                        <select class="form-select" name="id_category" required>
                            <option value="">Sélectionnez une catégorie</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?=$category['id'] ?>"><?= $category['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <?php if (isset($games)): ?>
                        <input type="hidden" name="id" value="<?= $games['id']; ?>">
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">
                        <?= isset($games) ? "Sauvegarder" : "Enregistrer" ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>