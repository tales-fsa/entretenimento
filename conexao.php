<?php
    define('host', 'localhost');
    define('user', 'root');
    define('pass', '');
    define('db', 'entretenimentos');

    $con = conexao(host, user, pass, db); 

    function conexao($host, $user, $pass, $db){

        $conect = new mysqli($host, $user, $pass, $db);

        if(!$conect){
            return 'Conexão falhou' . $conect->errno();
        }

        return $conect;
    }

?>