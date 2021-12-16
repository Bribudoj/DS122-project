<?php
include "header.php";

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    
    echo '<form id="form-test" class="form-horizontal" method="POST" action="">
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
        </form>';
        
}    
else{
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO MyGuests (firstname, lastname, email)
    VALUES ('John', 'Doe', 'john@example.com')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}

include "footer.php";
?>