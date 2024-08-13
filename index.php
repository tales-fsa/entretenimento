<?php 
include_once 'conexao.php';

function buscaTipos($con){
    $sql = 'SELECT id, nome FROM tipos_entretenimento';

    return $con->query($sql);
}

function buscaGeneros($con){
    $sql = 'SELECT id, nome FROM generos_entretenimento';

    return $con->query($sql);
}

function buscaEntretenimentos($con){
    $sql = 'SELECT li.id Ent_Id, li.nome Ent_Nome, li.`status` Ent_Status, li.imagem Ent_Img,
    tp.nome Tp_Nome, gen.nome Gen_Nome, pontuacao Ent_Pont, sinopse Ent_Sinop  FROM listagem_entretenimento li
    INNER JOIN tipos_entretenimento tp ON li.tipo_id = tp.id
    INNER JOIN generos_entretenimento gen ON li.genero_id = gen.id';

    return $con->query($sql);
}

$result_tipo = buscaTipos($con);
$result_genero = buscaGeneros($con);
$entretenimento = buscaEntretenimentos($con);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Cadastro de entretenimentos</h1>
    <form method="post" action="cadastro.php" enctype="multipart/form-data">
        <label for="nome">Entretenimento:</label>
        <input type="text" name="nome" id="nome" maxlength="50" placeholder="Digite um entretimento" required>
        <br><br>
        <textarea name="sinopse" id="sinopse" cols="60" rows="10" maxlength="500">     
        </textarea>
        <br><br>
        <label for="status">Status: </label>
        <select name="status" id="status">
            <option value="ativo">Ativo</option>
            <option value="inativo">Inativo</option>
        </select>
        <br><br>
        <label for="tipo">Tipo do entretenimento: </label>
        <select name="tipo" id="tipo">
            <?php foreach($result_tipo as $row){ ?>
                <option value=<?php echo $row['id'] ?>>
                     <?php echo $row['nome'] ?>
                </option>
            <?php } ?>    
        </select>
        <br><br>
        <label for="genero">Gênero do entretenimento: </label>
        <select name="genero" id="genero">
            <?php foreach($result_genero as $row){ ?>
                <option value=<?php echo $row['id'] ?>>
                     <?php echo $row['nome'] ?>
                </option>
            <?php } ?> 
        </select>
        <br><br>
        <label for="imagem">Imagem do entretenimento:</label>
        <input type="file" name="imagem" id="imagem">
        <br><br>
        <input type="submit" name="gravar" value="gravar">
    </form>

    <h2>Lista de Entretenimentos</h2>
    <?php foreach($entretenimento as $row){ ?>
        <p>
            <?php
                 echo $row['Ent_Id'] . ' - ' . $row['Ent_Nome'] . ' - ' . $row['Ent_Status'] . ' - ' . 
                    $row['Tp_Nome'] . ' - ' . $row['Gen_Nome'] . ' - ' . $row['Ent_Pont'] . ' - ' . $row['Ent_Sinop'] . ' - ' . $row['Ent_Img'] 
            ?>
            <button>
                <a href="editar.php?idupdate=<?php echo $row['Ent_Id'] ?>">Editar</a>
            </button>
            <button>
                <a  href="cadastro.php?idDelete=<?php echo $row['Ent_Id'] ?>">Excluir</a>
            </button>
        </p>
    <?php } ?>                
</body>
</html>