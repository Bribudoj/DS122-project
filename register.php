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

<h1>Dados para registro de novo usuário</h1>

<?php if ($success): ?>
  <h3 style="color:lightgreen;">Usuário criado com sucesso!</h3>
  <p>
    Seguir para <a href="login.php">login</a>.
  </p>
<?php endif; ?>

<?php if ($error): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
<?php endif; ?>
<?php if (!$success): ?>
<form action="register.php" method="post">
  <label for="name">Nome de Usuário: </label>
  <input type="text" name="name" value="<?php echo $name; ?>" required><br>
  
  <label for="email">Email: </label>
  <input type="text" name="email" value="<?php echo $email; ?>" required><br>

  <?php if ($error_mail): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
  <?php endif; ?>

  <label for="password">Senha: </label>
  <input type="password" name="password" value="" required><br>
  
  <?php if ($error_senha): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
  <?php endif; ?>

  <label for="confirm_password">Confirmação da Senha: </label>
  <input type="password" name="confirm_password" value="" required><br>
  
  <?php if ($error_senha): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
  <?php endif; ?>

  <input type="submit" name="submit" value="Criar usuário">
</form>
<?php endif; ?>

</p>

<?php
include "footer.php";
?>