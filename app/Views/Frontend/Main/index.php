<h1>Page d'accueil</h1>
<? foreach($articles as $article):?>
    <div class="card">
        <a href="/articles/details/<?=$article->id;?>">
            <h2><?= $article->titre;?></h2>
        </a>
        <p><?= $article->description;?></p>
    </div>
<? endforeach;?>