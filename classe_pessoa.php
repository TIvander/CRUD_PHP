<?php
Class Pessoa
{
    private $pdo;

        public function __construct($dbname, $host, $user, $password)
        {
            try
            {
                $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$password);
            }
            catch(PDOException $e)
            {
                echo "Erro com banco de dados: ".$e->getMessage();
                exit();
            }
            catch(Exception $e)
            {
                echo "Erro generico: ".$e->getMessage();
                exit();
            }
        }
    
    public function buscarDados()
    {
        $registro = array();
        $rs = $this->pdo->query("SELECT * FROM lista ORDER BY nome");  
        $registro = $rs->fetchAll(PDO::FETCH_ASSOC);
        return $registro;
    }

    public function cadastrarPessoa($nome, $telefone, $email)
    {
        $cmd = $this->pdo->prepare("SELECT ID FROM lista WHERE email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();

        if($cmd->rowCount() > 0)
        {
            return false;
        }
        else
        {
            $cmd = $this->pdo->prepare("INSERT INTO lista(nome, telefone, email) VALUES(:n, :t, :e)");

            $cmd->bindValue(":n", "$nome");
            $cmd->bindValue(":t", "$telefone");
            $cmd->bindValue(":e", "$email");
            $cmd->execute();
            return true;
        }
    }

    public function excluirPessoa($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM lista WHERE ID = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    public function buscarDadosPessoa($id)
    {
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM lista WHERE ID = :id");

        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);

        return $res;
    }

    public function atualizarDados($id, $nome, $telefone, $email)
    {
            $cmd = $this->pdo->prepare("UPDATE lista SET nome=:n, telefone=:t, email=:e WHERE ID=:id");

            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->bindValue(":id", $id);

            $cmd->execute();
 
    }
}
           
?>