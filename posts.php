<?php
include "header.php";

$conn = connect_db();
$sql = "SELECT thread_id, thread_subject, account_id FROM forum_thread";
$threads_db = mysqli_query($conn, $sql);

if (!$threads_db) {
    die("Error: " . $sql . "<br>" . mysqli_error($conn));
}

    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, "SELECT post_id, content, account_id, thread_id, username, creation_date FROM post
                                WHERE thread_id = ?");

    $thread_id = $_GET['id'];

    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "i", $thread_id);

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* bind result variables */
    $result = mysqli_stmt_get_result($stmt);

    /* close statement */
    mysqli_stmt_close($stmt);

    $stmt = mysqli_stmt_init($conn);

?>

<div class="content">
        <table>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($posts = mysqli_fetch_assoc($result)): ?>
                    <tr class="forum_post" id="forum_post_<?= $posts['post_id'] ?>">
                        <td>De: <?= $posts['username'] ?> </td>
                        <td><?= $posts['content'] ?></td>
                        <td><?= $posts['creation_date'] ?></td>
                    </tr>
                <?php endWhile; ?>
            <?php else: ?>
                Ainda não existe nenhum tópico.
            <?php endIF; ?>
      </table>
</div>


<?php 
include "create_post.php";
include "footer.php";
?>