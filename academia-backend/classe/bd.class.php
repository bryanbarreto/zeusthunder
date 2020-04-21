<?php
    class Bd{

        function conectar(){
            $string_conexao = "host=motty.db.elephantsql.com port=5432 dbname=tknpoldc user=tknpoldc password=yFlUO0Oz8OPlR602pFmfiIXktEFe2AuT";
            $con = pg_connect($string_conexao);
            if(!$con){
                throw new Exception("Erro ao realizar conexão com banco de dados");
            }
        }  
} 
?>