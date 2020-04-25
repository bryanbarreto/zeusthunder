<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste</title>
    <?php include 'includes/jeasyui.includes.php'; ?>
</head>
<body>
<?php include 'navbar.php'; ?>
<h2>Gerenciar Testes</h2>

<?php
   
   $cpf = "11998889742";

   $mes = date('m') <= 6? 1:2; 

   $finalCpf = substr($cpf, 8);

   $ano = date('Y');

   for($i=0;$i<3;$i++){ 
    $aleatorio .= rand(0,9);
   }

   echo "MATRICULA: ".$ano.".".$mes.".".$finalCpf.$aleatorio;
?>
</body>
</html>