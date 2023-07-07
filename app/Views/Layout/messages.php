<?php foreach (isset($_SESSION['messages']) ? $_SESSION['messages'] : [] as $status => $message) : ?>
    <?php if ($status == 'success') : ?>
        <div class="alert alert-success container mt-4" role="alert">
            <p>
                <?php echo $message;
                unset($_SESSION['messages']['success']); ?>
            </p>
        </div>
    <?php elseif ($status == 'error') : ?>
        <div class="alert alert-danger container mt-4" role="alert">
            <p>
                <?php echo $message;
                unset($_SESSION['messages']['error']); ?>
            </p>
        </div>
    <?php endif; ?>
<?php endforeach; ?>