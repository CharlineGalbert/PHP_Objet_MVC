<section class="container mt-4">
    <h1 class="text-center">Administration des utilisateurs</h1>
    <a href="/admin/articles/create" class="btn btn-primary">Créer un utilisateur</a>
    <div class="row gy-4 mt-4"> <!--gy = gap vertical-->
        <?php foreach($users as $user):?>
            <div class="col-md-4">
                <div class="card">
                    <h2 class="card-header"><?= "$user->nom $user->prenom";?></h2>
                    <div class="card-body">
                        <p class="text-muted"><?= $user->email;?></p>
                        <div class="d-flex justify-content-between">
                            <a href="/admin/users/edit/<?=$user->id; ?>" class="btn btn-warning">Modifier</a>
                            <form action="/admin/users/delete" method="POST" onsubmit="return confirm('Etes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                <input type="hidden" name="id" value="<?=$user->id;?>">
                                <input type="hidden" name="token" value="<?=$_SESSION['token'];?>">
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</section>