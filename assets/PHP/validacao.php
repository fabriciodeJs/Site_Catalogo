<?php
if (!empty($_POST['login']) and !empty($_POST['senha'])) {
   include('assets/PHP/Conexao.php');

   

   echo header("location: ../../Cadastro.php");
}else{
    die();
}

