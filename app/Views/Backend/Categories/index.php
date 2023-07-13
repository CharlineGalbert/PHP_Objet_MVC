<section class="container mt-4">
    <h1 class="text-center">Administration des catégories</h1>
    <div class="row gy-4 mt-4"> <!--gy = gap vertical-->
        <?php foreach($categories as $categorie):?>
            <div class="col-md-4">
                <div class="card">
                    <h2 class="card-header"><?= $categorie->nom ;?></h2>
                    <div class="card-body">
                        <p class="card-text"><?= $categorie->actif;?></p>
                        <p class="card-text"><?= date_format(new \DateTime($categorie->created_at), 'Y/m/d');?></p>
                        <div class="d-flex justify-content-between">
                            <a href="/admin/categories/edit/<?=$categorie->id; ?>" class="btn btn-warning">Modifier</a>
                            <form action="/admin/users/delete" method="POST" onsubmit="return confirm('Etes-vous sûr de vouloir supprimer cette catégorie ?')">
                                <input type="hidden" name="id" value="<?=$categorie->id;?>">
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