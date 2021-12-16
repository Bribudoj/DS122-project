<?php
include "header.php";

$error = false;
$password = $email = "";

if (!$login && $_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["email"]) && isset($_POST["password"])) {

    $conn = connect_db();

    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $password = mysqli_real_escape_string($conn,$_POST["password"]);
    $password = md5($password);

    $sql = "SELECT account_id,username,email,user_password FROM $table_users
            WHERE email = '$email';";

    $result = mysqli_query($conn, $sql);
    if($result){
      if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($user["user_password"] == $password) {

          $_SESSION["user_id"] = $user["account_id"];
          $_SESSION["user_name"] = $user["username"];
          $_SESSION["user_email"] = $user["email"];
          $_SESSION["signed_in"] = $login;

          header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
          exit();
        }
        else {
          $error_msg = "Senha incorreta!";
          $error = true;
        }
      }
      else{
        $error_msg = "Usuário não encontrado!";
        $error = true;
      }
    }
    else {
      $error_msg = mysqli_error($conn);
      $error = true;
    }
  }
  else {
    $error_msg = "Por favor, preencha todos os dados.";
    $error = true;
  }
}
?>

<h1>Login</h1>

<?php if ($login): ?>
    <h3>Você já está logado!</h3>
  </body>
  </html>
  <?php exit(); ?>
<?php endif; ?>

<?php if ($error): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
<?php endif; ?>

<form action="login.php" method="post">
  <label for="email">Email: </label>
  <input type="text" name="email" value="<?php echo $email; ?>" required><br>

  <label for="password">Senha: </label>
  <input type="password" name="password" value="" required><br>

  <input type="submit" name="submit" value="Entrar">
</form>

<ul>
  <li><a href="index.php">Voltar</a></li>
</ul>
</p>

<?php
include "footer.php";
?>