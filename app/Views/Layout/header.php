<header class="sticky-top">
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">My First MVC App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Articles</a>
                    </li>
                </ul>
            </div>
            <div class="ms-auto navbar-btn">
                <?php if(isset($_SESSION['LOGGED_USER'])):?>
                    <a href="#" class="btn btn-danger">Logout</a>
                <?php else:?>
                    <a href="/login" class="btn btn-light">Logout</a>
                <?php endif;?>
            </div>
        </div>
    </nav>
</header>
