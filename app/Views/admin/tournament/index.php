<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des Tournois</h4>
        <a href="<?= base_url('/admin/tournament/new'); ?>"><i class="fa-solid fa-plus"></i></a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Jeu</th>
                <th>Nombres de Places</th>
                <th>Date de Début</th>
                <th>Date de Fin</th>
                <th>Modifier</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tournaments as $tournament): ?>
                <tr>
                    <td><?= $tournament['id']; ?></td>
                    <td><?= $tournament['name']; ?></td>
                    <td><?= $tournament['game_name']; ?></td>
                    <td><?= $tournament['nb_player']; ?>/<?= $tournament['nb_player']; ?></td>
                    <td><?= $tournament['date_start']; ?></td>
                    <td><?= $tournament['date_end']; ?></td>
                    <td><a href="<?= base_url('/admin/tournament/' . $tournament['id']); ?>"> <i
                                class="fa-solid fa-pen"></i></a></td>
                    <td>    <?= ($tournament['deleted_at'] === null) ?        "<a title='Désactiver le tournoi' href='" . base_url("admin/tournament/deactivate/{$tournament['id']}") . "'><i class='fa-solid fa-xl fa-toggle-on text-success'></i></a>" :        "<a title='Activer le tournoi' href='" . base_url("admin/tournament/activate/{$tournament['id']}") . "'><i class='fa-solid fa-toggle-off fa-xl text-danger'></i></a>";    ?></td>
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
                    render:function (data) {
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
                    bsortable:false,
                    render:function (data) {
                        return `<a href="${baseUrl}admin/user/${data}"><i class="fa-solid fa-pencil"></i></a>`;
                    }
                },
                {
                    data : 'id',
                    sortable:false,
                    render:function (data, type, row) {
                        return (row.deleted_at === null ?
                            `<a title="Désactiver l'utilisateur" href="${baseUrl}admin/user/deactivate/${row.id}"><i class="fa-solid fa-xl fa-toggle-on text-success"></i>
                    </a>`:`< a title = "Activer un utilisateur" href = "${baseUrl}admin/user/activate/${row.id}" > <i class= "fa-solid fa-toggle-off fa-xl text-danger" > < /i></a> `);
                    }
                }
            ]
        });
    });
</script>