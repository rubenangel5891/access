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
     
    
    
    
    
    
    
   /******* CONSULTA SELECT ***************/
echo "******* PDO::query()**********<br/>";
    $stmt = $pdo->query('SELECT nombre FROM product');
    while ($row = $stmt->fetch())
    {
        echo $row['nombre'] . "<br/>";
    }
    
   
echo "******* PDO::PREPARE(), EXECUTE() **********<br/>";
    $sql  = "SELECT p.nombre, p.descripcion, p.precio";
    $sql .= "  FROM product p, product_category pc";
    $sql .= " WHERE p.Id  = pc.product_id";
    $sql .= " AND pc.category_id = :categoryId ";
    $sql .= " ORDER BY nombre";
    $categoryId = 1;
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['categoryId' => $categoryId]);
  //  $user = $stmt->fetch();
    while ($row = $stmt->fetch()) {
        $productName        = $row["nombre"];
        $productDescription = $row["descripcion"];
        $productPrice       = $row["precio"];

        echo $productName." | ".$productDescription." | ".$productPrice." <br/>";    
    }
    
    $stmt = $pdo->query('SELECT nombre, precio FROM product');
    foreach ($stmt as $row)
    {
        echo $row['nombre'] ." | ". $row['precio']. "<br/>";
    }
    
    
    
    
    
    /******* CONSULTA UPDATE***************/
echo "******* UPDATE **********<br/>"; 
    
    $data = [
        1 => 10,
        2 => 20,
        3 => 30,
    ];
    $stmt = $pdo->prepare('UPDATE product SET precio = precio + ? WHERE id = ?');
    foreach ($data as $id => $bonus)
    {
        $stmt->execute([$bonus, $id]);
    }
     
    $sql = "UPDATE product SET nombre = ? WHERE id = ?";
    $pdo->prepare($sql)->execute(["proct update", 1]);
    
echo "******* DELETE **********<br/>";     
    $stmt = $pdo->prepare("DELETE FROM product WHERE nombre = ?");
    $stmt->execute(["proct6"]);
    $deleted = $stmt->rowCount();
    echo $deleted ." eliminados <br/>";
    
    
    
echo "******* INSERT **********<br/>";    

    $stmt = $pdo->prepare("INSERT INTO product (nombre, descripcion, estado_venta, precio) VALUES (:nombre, :descripcion, :estado_venta, :precio)");
    $stmt->execute(['nombre' => "proctN", 'descripcion'=>"descripcionN", 'estado_venta'=>"ventaN", 'precio'=>0]);
     $insertado = $stmt->rowCount();
    echo $insertado ." insertadas <br/>";


    
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}