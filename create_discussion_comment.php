<?php
if ($login == true) {
?>
  <form id="discussion-form" class="form-horizontal" method="POST" action="">
    <div class="form-group">
      <label for="text">Adicione um comentário</label>
      <div>
        <textarea required class="form-control" name="comment" cols="2" rows="10" placeholder="Digite o seu primeiro post" value=""></textarea>
        <div class="help-block" id="erro-senha">

        </div>
        <?php if (!empty($erro_senha)) : ?>
          <span class="help-block"><?php echo $erro_senha ?></span>
        <?php endif; ?>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Enviar</button>
      </div>
    </div>
    </div>
  </form>

  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $conn = connect_db();
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "INSERT INTO post (content, account_id, username, thread_id, first_post)
                                    VALUES (? , ? , ?, ?, 'FALSE' )");

    $content = $_POST["comment"];
    $account_id = $user_id;
    $username = $user_name;
    $thread_id = $_GET["id"];

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "sisi", $content, $account_id, $username, $thread_id);

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* close statement */
    mysqli_stmt_close($stmt);

    $stmt = mysqli_stmt_init($conn);
  }

  mysqli_close($conn);
  ?>

<?php } else { ?>

  <div>
    Você precisa estar logado para acessar essa área!
  </div>

<?php } ?>