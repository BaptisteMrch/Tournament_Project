<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des Jeux</h4>
        <a href="<?= base_url('/admin/game/new'); ?>"><i class="fa-solid fa-user-plus"></i></a>
    </div>
    <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Modifier</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($games as $game): ?>
                        <tr>
                            <td><?= $game['id']; ?></td>
                            <td><?= $game['name']; ?></td>
                            <td><?= $game['id_category'];?></td>
                            <td><a href="<?= base_url('/admin/game/' . $game['id']); ?>"> <i class="fa-solid fa-pen"></i></a></td>
                            <td>
                                <?= $game['deleted_at'] === null
                                    ? '<span class="text-success">Actif</span>'
                                    : '<span class="text-danger">Supprimé</span>'; ?>
                            </td>
                            <td>
                                <?php if ($game['deleted_at'] === null): ?>
                                    <!-- Bouton pour désactiver -->
                                    <a href="<?= base_url("admin/game/deactivate/{$game['id']}"); ?>" title="Désactiver"><i class="fa-solid fa-toggle-on text-success"></i></a>
                                <?php else: ?>
                                    <!-- Bouton pour activer -->
                                    <a href="<?= base_url("admin/game/activate/{$game['id']}"); ?>" title="Activer"><i class="fa-solid fa-toggle-off text-danger"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>


<script>
    $(document).ready(function () {
        var baseUrl = "<?= base_url(); ?>";
        var dataTable = $('#tableUsers').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "language": {
                url: baseUrl + 'js/datatable/datatable-2.1.4-fr-FR.json',
            },
            "ajax": {
                "url": baseUrl + "admin/user/SearchUser",
                "type": "POST"
            },
            "columns": [
                {"data": "id"},
                {
                    data : 'avatar_url',
                    sortable : false,
                    render : function(data) {
                        if (data) {
                            return `<img src="${baseUrl}${data}" alt="Avatar" style="max-width: 20px; height: auto;">`;
                        } else {
                            // Retourne une image par défaut si data est vide
                            return '<img src="' + baseUrl + 'assets/img/avatars/1.jpg" alt="Default Avatar" style="max-width: 20px; height: auto;">';
                        }
                    }
                },
                {"data": "username"},
                {"data": "email"},
                {"data": "permission_name"},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a href="${baseUrl}admin/user/${data}"><i class="fa-solid fa-pencil"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable : false,
                    render : function(data, type, row) {
                        return (row.deleted_at === null ?
                            `<a title="Désactiver l'utilisateur" href="${baseUrl}admin/user/deactivate/${row.id}"><i class="fa-solid fa-xl fa-toggle-on text-success"></i></a>`: `<a title="Activer un utilisateur"href="${baseUrl}admin/user/activate/${row.id}"><i class="fa-solid fa-toggle-off fa-xl text-danger"></i></a>`);
                    }
                }
            ]
        });
    });

</script>