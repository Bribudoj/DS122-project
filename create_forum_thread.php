<?php
include "header.php";


if($_SERVER['REQUEST_METHOD'] != 'POST'){
?>    
    <form id="form-test" class="form-horizontal" method="POST" action="">
        <div class="form-group">
                <label for="threadTitle" class="col-sm-2 control-label">Título do Tópico</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" name="threadTitle" value="">
                    <div class="help-block" id="erro-dataNascimento">

                    </div>
                    <?php if (!empty($erro_dataNascimento)) : ?>
                        <span class="help-block"><?php echo $erro_dataNascimento ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">                                        
                <label for="text" class="col-sm-2 control-label">Senha</label>
                <div>
                    <textarea required class="form-control" name="post" cols="30" rows="10" placeholder="Digite o seu primeiro post" value=""></textarea>
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

        mysqli_stmt_bind_param($stmt, "sisi", $thread_subject, $account_id, $username, $thread_id);
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

include "footer.php";
?>