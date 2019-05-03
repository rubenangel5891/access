<?php

$host = '{Microsoft Access Driver (*.mdb)}';
$dbq   = filter_input (INPUT_SERVER,'DOCUMENT_ROOT',FILTER_SANITIZE_STRING)."/access/base_datos.mdb";
$charset = 'UTF-8';
$user = '';
$pass = '';


$dsn = "odbc:DRIVER=$host;DBQ=$dbq;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     
     echo "SELECT <br/>";
$productId = 1;
$sql  = "SELECT precio FROM product WHERE Id = " . $productId;
$result = $pdo->query($sql);
$row = $result->fetch();
$productPrice = $row["precio"];
echo $productPrice."<br />";
     
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}