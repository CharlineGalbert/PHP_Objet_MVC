<section class="container mt-4">
    <h1 class="text-center">Administration des articles</h1>
    <a href="/admin/articles/create" class="btn btn-primary">Créer un article</a>
    <div class="row gy-4 mt-4"> <!--gy = gap vertical-->
        <?php foreach($articles as $article):?>
            <div class="col-md-4">
                <div class="card <?= $article->getActif() ? 'border-success' : 'border-danger'; ?>">
                    <?php if($article->getImage()): ?>
                        <img src="/images/articles/<?= $article->getImage(); ?>" alt="<?= $article->getTitre(); ?>" class="card-img-top" loading="lazy">
                    <?php endif; ?>
                    <div class="card-body">
                        <h2 class="card-title"><?= $article->getTitre();?></h2>
                        <p class="text-muted"><?= $article->getCreatedAt()->format('d/m/Y');?></p>
                        <p class="card-text"><?= $article->getDescription();?></p>
                        <p class="card-text"><?= $article->getCategory()->nom;?></p>
                        <p class="text-actif-article <?= $article->getActif() ? 'text-success' : 'text-danger'; ?>"><?= $article->getActif() ? 'Actif' : 'Inactif';?></p>
                        <div class="form-check form-switch">
                            <input class="form-check-input switch-actif" type="checkbox" id="switch-visibility-<?= $article->getId(); ?>" <?=$article->getActif() ? 'checked' : null;?> data-id="<?= $article->getId(); ?>">
                            <label class="form-check-label" for="switch-visibility-<?= $article->getId(); ?>">Visibilité</label>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="/admin/articles/edit/<?=$article->getId(); ?>" class="btn btn-warning">Modifier</a>
                            <form action="/admin/articles/delete" method="POST" onsubmit="return confirm('Etes-vous sûr de vouloir supprimer cet article')">
                                <input type="hidden" name="id" value="<?=$article->getId();?>">
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