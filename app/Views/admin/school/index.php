<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des Ecoles</h4>
        <a href="<?= base_url('/admin/school/new'); ?>"><i class="fa-solid fa-plus"></i></a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Ville</th>
                <th>Catégorie</th>
                <th>Modifier</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($schools as $school): ?>
                <tr>
                    <td><?= $school['id']; ?></td>
                    <td><?= $school['name']; ?></td>
                    <td><?= $school['city']; ?></td>
                    <td><?= $school['id_category']; ?></td>
                    <td><a href="<?= base_url('/admin/school/' . $school['id']); ?>"> <i
                                    class="fa-solid fa-pen"></i></a></td>
                    <td>    <?= ($school['deleted_at'] === null) ?        "<a title='Désactiver l'école' href='" . base_url("admin/school/deactivate/{$school['id']}") . "'><i class='fa-solid fa-xl fa-toggle-on text-success'></i></a>" :        "<a title='Activer l'école' href='" . base_url("admin/school/activate/{$school['id']}") . "'><i class='fa-solid fa-toggle-off fa-xl text-danger'></i></a>";    ?></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function () {
        var baseUrl = "<?= base_url(); ?>";
        var dataTable = $('#tableSchool').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "language": {
                url: baseUrl + 'js/datatable/datatable-2.1.4-fr-FR.json',
            },
            "ajax": {
                "url": baseUrl + "admin/school/SearchSchool",
                "type": "POST"
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "city"},
                {
                    data : 'id',
                    sortable : false,
                    render : function(data) {
                        return `<a href="${baseUrl}admin/school/${data}"><i class="fa-solid fa-pencil"></i></a>`;
                    }
                },
            ]
        });
    });

</script>
