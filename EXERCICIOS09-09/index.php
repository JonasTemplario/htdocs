<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "Olá mundo </br></br>"; 

   
         


function dividirSeguro(mixed $a, mixed $b): ?float {
// Valide tipos: is_numeric() ou gettype()
if (!is_numeric($a) || !is_numeric($b)) {
    error_log("Erro: tipos inválidos");
    return null;
}
// Valide divisão por zero
if ($b == 0) {
    error_log("Erro: divisão por zero");
    return null;
}
return (float) $a / $b;
}
echo "<pre>";
var_dump(dividirSeguro(10, 2));   // float(5)
var_dump(dividirSeguro(10, 0));   // null + log
var_dump(dividirSeguro("a", 2));  // null + log