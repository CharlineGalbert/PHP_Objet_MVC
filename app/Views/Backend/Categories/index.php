<section class="container mt-4">
    <h1 class="text-center">Administration des catégories</h1>
    <a href="/admin/categories/create" class="btn btn-primary">Créer une catégorie</a>
    <div class="row gy-4 mt-4"> <!--gy = gap vertical-->
        <?php foreach($categories as $category):?>
            <div class="col-md-4">
                <div class="card <?= $category->actif ? 'border-success' : 'border-danger'; ?>">
                    <h2 class="card-header"><?= $category->nom ;?></h2>
                    <div class="card-body">
                        <p class="card-text">id=<?= $category->id ;?></p>
                        <p class="card-text"><?= date_format(new \DateTime($category->created_at), 'd/m/Y');?></p>
                        <p class="text-actif-tag <?= $category->actif ? 'text-success' : 'text-danger'; ?>"><?= $category->actif ? 'Actif' : 'Inactif';?></p>                        
                        <div class="form-check form-switch">
                            <input class="form-check-input switch-actif-tag" type="checkbox" id="switch-visibility-tag<?= $category->id; ?>" <?=$category->actif ? 'checked' : null;?> data-id="<?= $category->id; ?>">
                            <label class="form-check-label" for="switch-visibility-tag-<?= $category->id; ?>">Visibilité</label>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="/admin/categories/edit/<?=$category->id; ?>" class="btn btn-warning">Modifier</a>
                            <form action="/admin/categories/delete" method="POST" onsubmit="return confirm('Etes-vous sûr de vouloir supprimer cette catégorie ?')">
                                <input type="hidden" name="id" value="<?=$category->id;?>">
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