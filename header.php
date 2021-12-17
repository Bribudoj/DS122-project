<?php
require "authenticate.php";
include "db_functions.php";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Meu Fórum</title>
</head>

<body>

    <nav class="menu">
        <div class="menu--itens">
            <table>
                <tr>
                    <td class="menu-left">
                        <a class="tag is-link is-light" href="index.php">Home</a>
                    </td>
                    <td class="menu-right">
                        <?php if (!$login) { ?>
                    
                            <a href="login.php">Entrar</a>
                            <a href="register.php">Cadastre-se</a>                    
                        <?php } else { ?>
                            Olá <?php echo $user_name ?>, não é você?<a class="tag is-danger is-light" href="logout.php"> Sair</a>
                        <?php } ?>
                    </td>
                </div>
            </tr>
            </table>
        </div>
    </nav>
    <div class="wrapper">
        <?php if ($login) { ?>
            <div class="create-thread-btn"><a class="button is-link is-light" href="create_forum_thread.php">Crie um tópico!</a></div>
        <?php } ?>
       