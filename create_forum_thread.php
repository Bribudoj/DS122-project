<?php
include "header.php";

if ($login == true) {
if($_SERVER['REQUEST_METHOD'] != 'POST'){
?>    
    <form id="form-test" class="form-horizontal" method="POST" action="">
        <div>
                <div>
                    <input required type="text" class="input" name="threadTitle" placeholder="Título do Tópico" value="">
                </div>
            </div>

            <div>                                        
                <div>
                    <textarea required class="textarea" name="post" placeholder="Digite o seu primeiro post" value=""></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="create-thread-btn">
                    <button type="submit" class="button is-light is-link">Enviar</button>
                </div>
            </div>
        </form>
        

<?php    
}else{

    $conn = connect_db();
    $stmt = mysqli_stmt_init($conn);

    /* open transaction*/
    mysqli_begin_transaction($conn);

    try {
        mysqli_stmt_prepare($stmt, "INSERT INTO forum_thread (thread_subject, account_id, username)
                                    VALUES (? , ? , ? )");
        $thread_subject = $_POST["threadTitle"];
        $account_id = $user_id;
        $username = $user_name;

        /* bind parameters for markers */
        mysqli_stmt_bind_param($stmt, "sis", $thread_subject, $account_id, $username);

        /* execute query */
        mysqli_stmt_execute($stmt);

        /* fetch value */
        mysqli_stmt_fetch($stmt);

        /* close statement */
        mysqli_stmt_close($stmt);

        $stmt = mysqli_stmt_init($conn);

        mysqli_stmt_prepare($stmt, "INSERT INTO post (content, account_id, username, thread_id, first_post)
                                VALUES (? , ? , ? , ? , TRUE )");
        $content = $_POST["post"];
        $account_id = $user_id;
        $username = $user_name;
        $thread_id = mysqli_insert_id($conn);

        mysqli_stmt_bind_param($stmt, "sisi", $content, $account_id, $username, $thread_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        /* commit transaction */
        mysqli_commit($conn);

    } catch (mysqli_sql_exception $exception) {
        mysqli_rollback($conn);

        throw $exception;
    }

    mysqli_close($conn);
}
?>
<?php } else { ?>

<div>
  Você precisa estar logado para adicionar um comentário!
</div>

<?php
}
include "footer.php";
?>