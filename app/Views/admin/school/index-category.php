<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des catégories</h4>
        <a href="<?= base_url('/admin/schoolcategory/new'); ?>"><i class="fa-solid fa-circle-plus"></i></a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Slug</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category) : ?>
                <tr>
                    <td><?= $category['id']; ?></td>
                    <td><?= $category['name']; ?></td>
                    <td><?= $category['slug'];?></td>
                    <td><a href="<?= base_url('/admin/schoolcategory/' . $category['id']); ?>"> <i class="fa-solid fa-pen"></i></a></td>
                    <td><a href="<?= base_url('/admin/schoolcategory/delete/' . $category['id']); ?>"> <i class="fa-solid fa-trash"></i></a></td>

                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>


