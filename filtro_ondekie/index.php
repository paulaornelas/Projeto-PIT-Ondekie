<?php
header('Content-type: text/html; charset=utf8');
    include("./config.php");

    if(!empty($_GET['search']))
    {
        $data = $_GET['search'];
        $query = "SELECT * FROM pitbd.evento_local WHERE nome LIKE '%$data%' or categoria LIKE '%$data%' or endereco LIKE '%$data%' or nome_divulgador LIKE '%$data%' ORDER BY id DESC";
    }
    else
    {
        $query = "SELECT * FROM pitbd.evento_local  ORDER BY id DESC";
    }

    $result = $conexao->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Pesquisa | Ondekié</title>
    <style>
        body{
            background: #fff;
            color: #000;
            text-align: center;
        }
        .table-bg{
            background: rgba(0, 0, 0, 0.4);
            border-radius: 15px 15px 0 0;
        }

        .box-search{
            display: flex;
            justify-content: center;
            gap: .1%;
        }
        .navbar {
            background-color: #FF944D;
        }
        .navbar-title {
            color: #000;
            padding-top: 0.3125rem;
            padding-bottom: 0.2125rem;
            padding-left: 0.8125rem;
            margin-right: 1rem;
            font-size: 1.5rem;
            text-decoration: none;
        }
        .btn {
            background-color: #FF944D;
        }

        .cor {
            color: #000;
        }

        .cor-cor {
            color: #000;
            font-weight: 400;
        }

        a{
            text-decoration: none;
            color: #000;
        }
        a:hover{
            color: #000;
        }
        th, td {
            background-color: #fff;
            border-top: 0;
            border-bottom: 1px solid #000;
            border-left: 0;
            border-right: 0;
            border-radius: 15px 15px 0 0;
        }

        .ultima {
            border-right: 1px solid black;
        }

        .primeira {
            border-left: 1px solid black;
        }

        #sem {
            border: none;
            color: #000;
            font-weight: 400;
        }

        #refresh {
            margin-top: 2%;
            margin-right: 4%;
            padding: 8px 10px;
            border: 0.5px solid #FF944D;
            background-color: #fff;
            border-radius: 20%;
        }

        #espaco {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        #btnrel {
            border: 0.5px solid #000;
            background-color: #fff;
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <h1 class="navbar-title"> <a href="inicio.php"> <B>ONDEKIÉ<B> </a></h1>
        </div>
    </nav>
    <br>
    <br>
    <div class="box-search">
        <input type="search" class="form-control w-25" placeholder="Pesquisar..." id="pesquisar">
        <button onclick="searchData()" class="btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
        </button>
    </div>

    <div id="espaco">
        <button id="refresh" onclick="reloadPage()">
            <img src="refresh.svg" width="20px">
        </button>
    </div>

    <div class="m-5">
        <table class="table text-white " >
            <thead>
                <tr>
                    <th scope="col" class="cor">Nome</th>
                    <th scope="col" class="cor">Categoria</th>
                    <th scope="col" class="cor">Endereço</th>
                    <th scope="col" class="cor">Descrição</th>
                    <th scope="col" class="cor">Divulgador</th>
                    <th scope="col" class="cor"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                if(mysqli_num_rows($result) > 0) {
                    while($user_data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        
                        echo "<td class='cor-cor primeira'>".$user_data['nome']."</td>";
                        echo "<td class='cor-cor'>".$user_data['categoria']."</td>";
                        echo "<td class='cor-cor'>".$user_data['endereco']."</td>";
                        echo "<td class='cor-cor'>".$user_data['descricao']."</td>";
                        echo "<td class='cor-cor'>".$user_data['nome_divulgador']."</td>";
                
                        echo '<td class="cor-cor ultima">
                                <form method="post" action="../gerar_relatorio/htdocs/index.php">
                                    <input type="hidden" name="id" value="' . $user_data['id'] . '" />
                                    <input type="submit" name="botao" value="Baixar Relatório" id="btnrel">
                                </form>
                            </td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' id='sem'>Nenhum registro encontrado!</td></tr>";
                }
                
                    
                    ?>
            </tbody>
        </table>
    </div>
</body>
    <script>
        var search = document.getElementById('pesquisar');


            search.addEventListener("keydown", function(event) {
                if (event.key === "Enter") 
                {
                    searchData();
                }
            });

        
            function searchData()
            {
                window.location = 'index.php?search='+search.value;
        }

        function reloadPage() {
            location.reload();
        }
    </script>
</html>