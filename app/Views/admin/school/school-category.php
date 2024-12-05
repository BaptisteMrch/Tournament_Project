<form action="<?= isset($category) ? base_url("/admin/schoolcategory/update") : base_url("/admin/schoolcategory/create"); ?>"
      method="POST">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <?= isset($category) ? "Editer " . $category['name'] : "Créer une catégorie" ?>
            </h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Nom de la catégorie</label>
                <input type="text" class="form-control" id="name" placeholder="name" value="<?= isset($category) ? $category['name'] : ""; ?>" name="name">
            </div>
        </div>
        <div class="card-footer text-end">
            <?php if (isset($category)): ?>
                <input type="hidden" name="id" value="<?= $category['id']; ?>">
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">
                <?= isset($category) ? "Sauvegarder" : "Enregistrer" ?>
            </button>
        </div>
    </div>
</form>
