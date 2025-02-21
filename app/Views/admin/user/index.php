<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Liste des utilisateurs</h4>
        <div>
            <button id="btnSetApiLimit" class="btn btn-outline-primary me-2">Limiter les requêtes API</button>
            <a href="<?= base_url('/admin/user/new'); ?>"><i class="fa-solid fa-user-plus"></i></a>
        </div>
    </div>
    <div class="card-body">
        <table id="tableUsers" class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Username</th>
                <th>Mail</th>
                <th>Rôle</th>
                <th>Modifier</th>
                <th>Actif</th>
            </tr>
            </thead>
            <tbody>
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

        // JavaScript + PHP : Intégration complète pour modifier la limite de requêtes API et mettre à jour le 'counter' dans la table api_token

        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('btnSetApiLimit');

            const modal = document.createElement('div');
            modal.id = 'apiLimitModal';
            modal.style.display = 'none';
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';

            modal.innerHTML = `
        <div style="background: white; padding: 20px; border-radius: 10px; max-width: 300px; width: 100%; text-align: center;">
            <h3>Définir la limite API</h3>
            <select id="apiLimitSelect" class="form-select mb-3">
                <option value="10">10 requêtes/jour</option>
                <option value="100">100 requêtes/jour</option>
                <option value="200">200 requêtes/jour</option>
                <option value="infinite">Illimité</option>
            </select>
            <div class="d-flex justify-content-between">
                <button id="saveApiLimit" class="btn btn-success">Enregistrer</button>
                <button id="closeApiLimitModal" class="btn btn-secondary">Fermer</button>
            </div>
        </div>
    `;
            document.body.appendChild(modal);

            button.addEventListener('click', function() {
                modal.style.display = 'flex';
            });

            document.addEventListener('click', function(event) {
                if (event.target.id === 'closeApiLimitModal' || event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            document.getElementById('saveApiLimit').addEventListener('click', function() {
                const selectedLimit = document.getElementById('apiLimitSelect').value;

                fetch('/api/login/setRequestLimit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ limit: selectedLimit })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Limite de requêtes mise à jour : ' + selectedLimit);
                        } else {
                            alert('Erreur : ' + data.message);
                        }
                        modal.style.display = 'none';
                    })
                    .catch(error => console.error('Erreur lors de la mise à jour :', error));
            });
        });

</script>