<html> 
<head> 
<script language="javascript" type="text/javascript">
function MiFuncionJS()
{ 
    while (true){ 
        var vr1 = prompt("Ingrese cantidad a pagar");
        var vr2 = prompt("Ingrese cantidad de pago ");
        if(parseFloat(vr2)>=parseFloat(vr1)){
            var p = parseFloat(vr1)-parseFloat(vr2);
            if(parseFloat(p)<0)
            {
                p=parseFloat(p)*(-1)
            }
            alert("Su cambio es: "+p);
            break;
        }
        alert("La cantidad con la que te estan pagando es menor al monto o puso una letra.")
    }
}
</script>
</head> 
<body> 
<? 
if ($variable=="valor"){ 
?> 
<script languaje="javascript"> 
MiFuncionJS(); 
</script> 
<?php

if(isset($_SESSION["admin_id"])){

$buy =  BuyData::getById($_GET["id"]);
$buy->status_id = $_GET["status"];
$buy->change_status();



Core::redir("index.php?view=sells");
}
?>
</body> 
</html>


