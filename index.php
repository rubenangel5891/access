<?php

//$dbName = "C:\\www\\access\\base_datos.mdb"; 
//echo filter_input (INPUT_SERVER, 'DOCUMENT_ROOT',FILTER_SANITIZE_STRING);
//echo filter_input (INPUT_SERVER,'DOCUMENT_ROOT',FILTER_SANITIZE_STRING);
$dbName = filter_input (INPUT_SERVER,'DOCUMENT_ROOT',FILTER_SANITIZE_STRING)."/access/base_datos.mdb";

if (!file_exists($dbName)) {
    die("Error, archivo no encontrado");
}

try{
//conección a la base de datos
$db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)};charset=UTF-8; DBQ=$dbName; Uid=; Pwd=;");

//CONSULTA**********************************************************************************************************
echo "SELECT <br/>";
$productId = 1;
$sql  = "SELECT precio FROM product WHERE Id = " . $productId;
$result = $db->query($sql);
$row = $result->fetch();
$productPrice = $row["precio"];
echo $productPrice."<br />";

$categoryId = 1;

$sql  = "SELECT p.nombre, p.descripcion, p.precio";
$sql .= "  FROM product p, product_category pc";
$sql .= " WHERE p.Id  = pc.product_id";
$sql .= " AND pc.category_id = " . $categoryId;
$sql .= " ORDER BY nombre";

//$result2 = $db->query($sql);
$b1=$db->prepare($sql);
$b1->execute();
//$result2=$b1->GetArray();

while ($row = $b1->fetch()) {
    $productName        = $row["nombre"];
    $productDescription = $row["descripcion"];
    $productPrice       = $row["precio"];
    
    echo $productName." | ".$productDescription." | ".$productPrice." <br/>";    
}

//ACTUALIZACIÓN**********************************************************************************************************
echo "UPDATE <br/>";

//$strName2 = "zzzz";
$strDescription1 = 'zzzz';
$strPrice1 = 1212;
$strStatus1 = 'zzzz';
$productId1 = 1;

//echo $db->quote($strDescription1); 

$sql1  = "UPDATE product";
$sql1 .= "   SET descripcion = " .$strDescription1 . ",";
$sql1 .= "       precio       =  " . $strPrice1 . ",";
$sql1 .= "       estado_venta = " . $strStatus1;
$sql1 .= " WHERE Id = ". $productId1;
//echo $sql1; 
//$db->query($sql1);

$b2=$db->prepare($sql1);
$b2->execute();


//INSERTAR**********************************************************************************************************
echo "INSERT <br/>";

$strName2 = "zzzz";
$strDescription2 = 'zzzz';
$strPrice2 = 1212;
$strStatus2 = 'zzzz';



$sql2  = "INSERT INTO product";
$sql2 .= "       (nombre, descripcion, estado_venta, precio) ";
$sql2 .= "VALUES (" .$strName2. ", " .$strDescription2. ", " .$strPrice2. ", " .$strStatus2. ")";

$b3=$db->prepare($sql2);
$b3->execute();

}
catch (PDOException $e) {
  echo $e->getMessage("Error en la conección a la base de datos");
}





