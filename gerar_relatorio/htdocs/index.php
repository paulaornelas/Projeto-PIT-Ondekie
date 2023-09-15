<?php
    include('config.php');

    //Variavel_id que vai ser recebida pelo post para ser utilizada na consulta do select
    $id = $_POST['id'];

    $sql = "SELECT * FROM evento_local where id = $id " ;

    $res = $conn->query($sql);
    
    // print "<table>";
    if($res->num_rows > 0){
        $html = "<br>";
        while($row = $res->fetch_object()) {
            // $html .= "<tr>";
           // $html .= "<td>".$row->id_evento."</td>";
          //  $html .= $row->id_evento."<br><hr>";

            $html .= $row->nome."<br><hr border='none'>";
            $html .= "<p>Categoria: </p>".$row->categoria."<br><hr>";
            $html .= "<p>Local: </p>".$row->endereco."<br><hr>";
            $html .= "<p>Descrição: </p>".$row->descricao."<br><hr>";
        }
        $html .= "<br>";
    } else {
        $html .= ('Nenhum dado registrado');
    }

    // gerar o pdf

    use Dompdf\Dompdf;

    require_once 'dompdf/autoload.inc.php';

    $dompdf = new Dompdf();

    $dompdf->loadHtml($html);

    $dompdf->set_option('arial', 'sans');

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $dompdf->stream("Relatório");
?>