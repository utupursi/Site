<div>
    <h1>About us</h1>

    <?php require_once __DIR__ . '/../helpers.php';
      if(isLoggedIn()):?>
      <dl>
            <dt>Name:</dt>
            <dd><?php echo currentUser()['full_name'] ?></dd>
            <dt>Email:</dt>
            <dd><?php echo currentUser()['email'] ?></dd>
        </dl>
        <?php endif; ?>
  


</div>
