<header class="p-3 text-bg-dark">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="<?php echo URLROOT ?>" class="nav-link px-2 text-secondary text-white">Home</a></li>
          <li><a href="<?php echo URLROOT ?>/pages/about" class="nav-link px-2 text-secondary">About</a></li>
          <?php if(isLoggedIn()) : ?>
            <li><a href="<?php echo URLROOT ?>/posts" class="nav-link px-2 text-secondary">Posts</a></li>
          <?php endif ?>
        </ul>
        <div class="text-end">
          <?php if(!isLoggedIn()) : ?>
            <button onclick="window.location.href = '<?php echo URLROOT ?>/users/login'" type="button" class="btn btn-outline-light me-2">Login</button>
            <button onclick="window.location.href = '<?php echo URLROOT ?>/users/register'" type="button" class="btn btn-warning">Sign-up</button>
            <?php else : ?>
              <button  type="button" class="btn btn-light">Welcome, <?php echo $_SESSION['user']['name'];  ?></button>
            <button onclick="window.location.href = '<?php echo URLROOT ?>/users/logout'" type="button" class="btn btn-outline-light me-2">Logout</button>
          <?php endif ?>
        </div>
      </div>
    </div>
</header>