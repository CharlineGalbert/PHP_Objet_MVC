<?php include_once '_slider.php'?>

<section class="container mt-4">
    <h2 class="text-center">Derniers articles</h2>
    <div class="row gy-4 mt-4">
        <?php foreach ($articles as $article) : ?>
            <div class="col-md-4">
                <div class="card">
                    <?php if ($article->image) : ?>
                        <img src="/images/articles/<?= $article->image; ?>" alt="<?= $article->titre; ?>" loading="lazy" class="card-img-top">
                    <?php endif; ?>
                    <div class="card-body">
                        <h3 class="card-title"><?= $article->titre; ?></h3>
                        <p class="text-muted"><?= date_format(new \DateTime($article->created_at), 'd/m/Y'); ?></p>
                        <p class="card-text"><?= $article->description; ?></p>
                        <a href="/articles/details/<?= $article->id; ?>" class="btn btn-primary mt-2">En savoir plus</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
