<?php
if ($login == true) {
?>
  <form id="discussion-form" class="form-horizontal" method="POST" action="">
    <div>
      <div>
        <textarea required class="textarea" name="comment" placeholder="Adicione um comentário" value=""></textarea>
      </div>
    </div>
    <div>
      <div class="create-thread-btn">
        <button type="submit" class="button is-link is-light ">Enviar</button>
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

  <article class="message is-danger">
    <div class="message-body">
      Você precisa estar logado para acessar essa área!
    </div>
  </article>

<?php } ?>