<?php

require_once 'classe_pessoa.php';
$p = new Pessoa("teste", "127.0.0.1:3308", "root", "");
?>

<!DOCTYPE html>

<html>
    <head>

        <meta charset="utf-8">
        <title>Cadastro Pessoa</title>
        <link rel="stylesheet" href="style.css"> 

    </head>
    <body>
    <?php

        
        if(isset($_POST['nome'])) 
        {
            if(isset($_REQUEST['id_up']) && !empty($_REQUEST['id_up']))
            {
                $id_upd = addslashes($_REQUEST['id_up']);
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                
                if(!empty($nome) && !empty($telefone) && !empty($email))
                {

                    $p->atualizarDados($id_upd, $nome, $telefone, $email);
                    header("location:index.php");
                }
                else
                {   
                    ?>
                        <div class="aviso">
                            <img src="aviso.png">
                            <h4>Preencha todos os campos</h4>
                        </div>
                    <?php
                }
            }
            else
            {
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                
                if(!empty($nome) && !empty($telefone) && !empty($email))
                {

                    if(!$p->cadastrarPessoa($nome, $telefone, $email))
                    {
                        ?>
                        <div class="aviso">
                            <img src="aviso.png">
                            <h4>Email já cadastrado!</h4>
                        </div>                       
                        <?php
                        
                    }
                }
                else
                {
                   ?>
                    <div class="aviso">
                        <img src="aviso.png">
                        <h4>Preencha todos os campos!</h4>
                    </div>
                    
                    <?php
                } 
            }

        }
    ?>
    <?php
        if(isset($_REQUEST['id_up']))
        {
            $id_update = addslashes($_REQUEST['id_up']);
            $res = $p->buscarDadosPessoa($id_update);
        }
    ?>
        <section id="esquerda">
            <form method="POST">

                <h2>Cadastrar Pessoa</h2>

                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['NOME'];} ?>">

                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone" value="<?php if(isset($res)){echo $res['TELEFONE'];} ?>">

                <label for="email">E-mail</label>
                <input type="text" name="email" id="email" value="<?php if(isset($res)){echo $res['EMAIL'];} ?>">

                <input type="submit" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">

            </form>
        </section>

        <section id="direita">
        <table>
                <tr id="titulo">
                    <td>Nome</td>
                    <td>Telefone</td>               
                    <td colspan="2">Email</td>
                </tr>
        <?php

            $dados = $p->buscarDados();
            if(count($dados) > 0)
            {
                for($i=0; $i < count($dados); $i++)
                {   
                    echo "<tr>";
                        foreach($dados[$i] as $k => $v)
                        {
                            if($k != "ID")
                            {
                                echo "<td>". $v ."</td>";
                            }
                        }
                        ?>
                        <td><a href="?id=<?php echo $dados[$i]["ID"];?>">Excluir</a><a href="?id_up=<?php echo $dados[$i]["ID"];?>">Editar</a></td>
                        <?php
                    echo "</tr>";
                }
            }
            else
            { 
            ?>
            </table>

                    <div class="aviso">
                        <h4>Não há pessoas cadastradas!</h4>
                    </div>

            <?php
            }

        ?>
        </section>
    </body>
</html>
<?php
    if(isset($_REQUEST['id']))
    {
        $id_pessoa= addslashes($_REQUEST['id']);
        $p->excluirPessoa($id_pessoa);
        header("location: index.php");
    }
?>