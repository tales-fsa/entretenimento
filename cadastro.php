<?php
    include_once 'conexao.php';

    if(isset($_POST['gravar'])){
        if(isset($_POST['nome']) && isset($_POST['sinopse']) && isset($_POST['status']) && isset($_POST['tipo']) && isset($_POST['genero'])){
            $nome = $_POST['nome'];
            $sinopse = $_POST['sinopse'];
            $status = $_POST['status'];
            $imagem = $_FILES['imagem']['name'];
            $genero = $_POST['genero'];
            $tipo   = $_POST['tipo'];

            $destino = 'img/' . $imagem; 
            $arquivo = $_FILES['imagem']['tmp_name'];
            move_uploaded_file($arquivo, $destino);

            $resultAdd = cadastrarEntretenimento($con, $nome, $sinopse, $status, $imagem, $tipo, $genero);

            if($resultAdd){
                header('location: index.php');
            } else {
                echo $resultAdd;
            }
        }
    }

    if(isset($_GET['idDelete'])){
        $idExcluir = $_GET['idDelete'];
        
        $resultDel = excluirEntretenimento($con, $idExcluir);

        if($resultDel){
                header('location: index.php');
            } else {
                echo $resultDel;
            }
    }
    

    function cadastrarEntretenimento($con, $nome, $sinopse, $status, $imagem, $tipo, $genero){
        $sql = "INSERT INTO listagem_entretenimento (nome, sinopse, `status`, imagem, tipo_id, genero_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
    
        $stmt->bind_param("ssssii", $nome, $sinopse, $status, $imagem, $tipo, $genero);
        
        $stmt->execute();

        return $stmt ? 'Cadastrado com sucesso' : 'Erro ao realizar o cadastro '. $stmt->errno();
    }

    function excluirEntretenimento($con, $id){
        $sql = "DELETE FROM listagem_entretenimento WHERE id = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt ? 'Entretenimento excluido com sucesso' : 'Erro ao excluir o registro' . $stmt->errno();
    }

?>