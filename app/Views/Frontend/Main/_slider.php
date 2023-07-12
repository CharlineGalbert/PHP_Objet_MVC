<div id="slider-main" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php foreach ($articles as $key => $article) : ?> <!--$articles est un tableau à index-->
            <?php if ($key === array_key_first($articles)) : ?>
                <button type="button" data-bs-target="#slider-main" data-bs-slide-to="<?= $key; ?>" class="active" aria-current="true" aria-label=" <?= $key; ?>"></button>
            <?php else : ?>
                <button type="button" data-bs-target="#slider-main" data-bs-slide-to="<?= $key; ?>" aria-label="Slide <?= $key; ?>"></button>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="carousel-inner">
        <?php foreach ($articles as $key => $article) : ?>
            <div class="carousel-item <?= $key === array_key_first($articles) ? 'active' : '' ?>">
                <?php if ($article->image) : ?>
                    <img src="/images/articles/<?= $article->image; ?>" class="img-carousel d-block" alt="<?= $article->titre; ?>" loading="lazy" />
                <?php else : ?>
                    <img src="https://fakeimg.pl/1200x600" class="img-carousel d-block w-100">
                <?php endif; ?>
                <div class="carousel-caption d-none d-md-block">
                    <h2><?= $article->titre; ?></h2>
                    <p><?= strlen($article->description) > 150 ? substr($article->description, 0, 150) . '...' : $article->description; ?></p>
                    <a href="/articles/details/<?= $article->id ?>" class="btn btn-primary">En savoir plus</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#slider-main" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#slider-main" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>