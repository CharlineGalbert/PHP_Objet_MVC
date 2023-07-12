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
            <div class="ms-auto navbar-btn d-flex">
                <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                    <?php if (in_array('ROLE_ADMIN', $_SESSION['LOGGED_USER']['roles'])) : ?>
                        <div class="dropdown open me-4">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Admin
                            </button>
                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                <a class="dropdown-item" href="/admin/articles">Articles</a>
                                <a class="dropdown-item" href="/admin/users">Users</a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <a href="/logout" class="btn btn-danger">Logout</a>
                <?php else : ?>
                    <a href="/login" class="btn btn-light">Caca</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
