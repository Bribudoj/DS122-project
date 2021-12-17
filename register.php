<?php
include "header.php";

$error = false;
$error_senha = false;
$error_mail = false;
$success = false;
$name = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {

    $conn = connect_db();

    $name = mysqli_real_escape_string($conn,$_POST["name"]);
    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $password = mysqli_real_escape_string($conn,$_POST["password"]);
    $confirm_password = mysqli_real_escape_string($conn,$_POST["confirm_password"]);

    if ($password == $confirm_password && filter_var($email, FILTER_VALIDATE_EMAIL)) { 
      $password = md5($password);

      $sql = "INSERT INTO $table_users
              (username, email, user_password) VALUES
              ('$name', '$email', '$password');";

      if(mysqli_query($conn, $sql)){
        $success = true;
      }
      else {
        $error_msg = mysqli_error($conn);
        $error = true;    }
    }
    else {
      if($password != $confirm_password){
        $error_msg = "Senha não confere com a confirmação.";
        $error_senha = true;
      }else{
        $error_msg = "Digite um email válido";
        $error_mail = true;
      }
    }
  }
  else {
    $error_msg = "Por favor, preencha todos os dados.";
    $error = true;
  }
}
?>



<?php if ($success): ?>
  <article class="message is-success"><div class="message-body">Usuário criado com sucesso!</div></article>
  <p>
    Seguir para <a href="login.php">login</a>.
  </p>
<?php endif; ?>

<?php if ($error): ?>
  <article class="message is-danger"><div class="message-body"><?php echo $error_msg; ?></div></article>
<?php endif; ?>
<?php if (!$success): ?>

<div class="form-component">
  <h1>Dados para registro de novo usuário</h1>
  <form action="register.php" method="post">

    <div class="form-component-input">
      <input class="input" type="text" name="name" placeholder="Nome de Usuário" value="<?php echo $name; ?>" required><br>
    </div>

    <div class="form-component-input">
      <input class="input" type="text" name="email" placeholder="Email:" value="<?php echo $email; ?>" required><br>
    </div>
    <?php if ($error_mail): ?>
      <article class="message is-danger"><div class="message-body"><?php echo $error_msg; ?></div></article>
    <?php endif; ?>

    <div class="form-component-input">
      <input class="input" type="password" name="password" placeholder="Senha:" value="" required><br>
    </div>
    <?php if ($error_senha): ?>
      <article class="message is-danger"><div class="message-body"><?php echo $error_msg; ?></div></article>
    <?php endif; ?>

    <div class="form-component-input">
      <input class="input" type="password" name="confirm_password" placeholder="Confirmação da Senha:" value="" required><br>
    </div>

    <?php if ($error_senha): ?>
      <article class="message is-danger"><div class="message-body"><?php echo $error_msg; ?></div></article>
    <?php endif; ?>

    <input class="button is-light is-link" type="submit" name="submit" value="Criar usuário">
  </form>
  </div>
<?php endif; ?>

</p>

<?php
include "footer.php";
?>