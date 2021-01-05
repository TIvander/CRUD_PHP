<?php
//------------------------CONEXAO------------------------------
    try
    {

        $pdo = new PDO("mysql:dbname=teste;host=127.0.0.1:3308","root","");
        echo "connected!";
    }
    catch(PDOException $e)
    {

        echo "Erro com banco de Dados: ".$e->getMessage();

    }
    catch(Exception $e)
    {

        echo "Erro genérico: ".$e->getMessage();

    }

//------------------------INSERT------------------------------
//PRIMEIRA FORMA------------------------------------------
/*$sql = "INSERT INTO lista(nome, telefone, email) VALUES(:n, :t, :e)";
$res = $pdo->prepare($sql);

$res->bindValue(":n", "Miriam");
$res->bindValue(":t"," 000000");
$res->bindValue(":e", "teste@gmail.com");

$res->execute();
*/
//SEGUNDA FORMA------------------------------------------
//$pdo->query("INSERT INTO lista(nome, telefone, email) VALUES('Miriam', '000000', 'teste@gmail.com')");




//------------------------DELETE------------------------------
/*
$res = $pdo->prepare("DELETE FROM lista WHERE ID=:id");

$id = 2;
$res->bindValue(":id", $id);
$res->execute();

*/
//------------------------UPDATE------------------------------
/*$res = $pdo->prepare("UPDATE lista SET nome = :n, telefone = :t, email = :e WHERE id = :id");

$res->bindValue(":n","PAULÃO");
$res->bindValue(":t","1111111");
$res->bindValue(":e","pa@mail.com");
$res->bindValue(":id","5");
$res->execute();
*/

//------------------------select------------------------------
//----------------------FORMA NORMAL UTILIZADA
/*$rs = $pdo->prepare("SELECT nome, telefone, email FROM lista");

if($rs->execute())
{
    while($registro = $rs->fetch(PDO::FETCH_OBJ))
    {
        echo"<hr>";
            echo "<td>". $registro->nome ."</td>" . "<br>";
            echo "<td>". $registro->telefone ."</td>" . "<br>";
            echo "<td>". $registro->email ."</td>" . "<br>";
        
    }
}
else
{
    echo "registros não encontrados.";
}
*/
//------------FROMA PARA TRAZER DADOS EM UM ARRRAY------------
$cmd = $pdo->prepare("SELECT * FROM lista WHERE id=:id");
$cmd->bindValue(":id", "4");
$cmd->execute();

$resultado = $cmd->fetch(PDO::FETCH_ASSOC);
//ou
//$cmd->fetchAll();
//print_r($resultado);
//var_dump($resultado);


?>
