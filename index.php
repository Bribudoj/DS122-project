<?php
include "header.php";


$conn = connect_db();
$sql = "SELECT thread_id, thread_subject, username, account_id, creation_date FROM forum_thread";
$threads_db = mysqli_query($conn, $sql);

if (!$threads_db) {
    die("Error: " . $sql . "<br>" . mysqli_error($conn));
}

mysqli_close($conn);

?>

    <div class="content-page">
        <table>
            <?php if (mysqli_num_rows($threads_db) > 0): ?>
                <?php while($thread = mysqli_fetch_assoc($threads_db)): ?>
                    <tr class="threads" id="thread<?= $thread['thread_id'] ?>">
                        <td class="button is-info is-light"><?= $thread['username'] ?> </td>
                        <td class="button is-warning"><a href="thread_discussion.php?id=<?= $thread['thread_id'] ?>"><?= $thread['thread_subject'] ?></a></td>
                        <td class="button is-primary is-light">em <?= $thread['creation_date'] ?></td>
                    </tr>
                <?php endWhile; ?>
        <?php else: ?>
            Ainda não existe nenhum tópico.
        <?php endIF; ?>
      </table>
    </div>


<?php
include "footer.php";
?>
