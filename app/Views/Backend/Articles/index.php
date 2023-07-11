<section class="container mt-4">
    <h1 class="text-center">Administration des articles</h1>
    <a href="/admin/articles/create" class="btn btn-primary">Créer un article</a>
    <div class="row gy-4 mt-4"> <!--gy = gap vertical-->
        <?php foreach($articles as $article):?>
            <div class="col-md-4">
                <div class="card <?= $article->actif ? 'border-success' : 'border-danger'; ?>">
                    <h2 class="card-header"><?= $article->titre;?></h2>
                    <div class="card-body">
                        <p class="text-muted"><?= date_format(new \DateTime($article->created_at), 'Y/m/d');?></p>
                        <p class="card-text"><?= $article->description;?></p>
                        <p class="text-actif-article <?= $article->actif ? 'text-success' : 'text-danger'; ?>"><?= $article->actif ? 'Actif' : 'Inactif';?></p>
                        <div class="form-check form-switch">
                            <input class="form-check-input switch-actif" type="checkbox" id="switch-visibility-<?= $article->id; ?>" <?=$article->actif ? 'checked' : null;?> data-id="<?= $article->id; ?>">
                            <label class="form-check-label" for="switch-visibility-<?= $article->id; ?>">Visibilité</label>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="/admin/articles/edit/<?=$article->id; ?>" class="btn btn-warning">Modifier</a>
                            <form action="/admin/articles/delete" method="POST" onsubmit="return confirm('Etes-vous sûr de vouloir supprimer cet article')">
                                <input type="hidden" name="id" value="<?=$article->id;?>">
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