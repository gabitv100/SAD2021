<?php
$conexao = mysqli_connect("localhost", "Viwer", "123456", "sad");
if (mysqli_connect_errno()) {
    printf("Conecto não: %s\n", mysqli_connect_error());
    exit();
}



$query = "Select * from ds_candidato where `NM_UE` not like '#NULO#' ORDER BY `NM_UE` ";



?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Sistema SAD-UFMT 2020 - Gabriel Viana</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Analise de Despesas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active " aria-current="page" href="despesasTotais.php">Despesas Totais</a>
                    <a class="nav-link" href="despesasMunicipio.php">Despesas Por Município</a>
                    <a class="nav-link" href="despesasPartido.php">Por Partido</a>
                    <a class="nav-link" href="despesasCandidato.php">Por Canditatos</a>

                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <table class="table table-striped table-hover">
            <thead>
                <th>
                    Município
                </th>
                <th>
                    Data de Prestação
                </th>
                <th>
                    Sigla do Partido
                </th>
                <th>
                    Descrição
                </th>
                <th>
                    Valor
                </th>
            </thead>
            <tbody id="tabela">
                <?php
                if ($result = mysqli_query($conexao, $query)) {
                    while ($linha = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $linha['NM_UE'] . '</td>';
                        echo '<td>' . $linha['DT_PRESTACAO_CONTAS'] . '</td>';
                        echo '<td>' . $linha['NM_PARTIDO'] . '</td>';
                        echo '<td> ' . $linha['DS_DESPESA'] . '</td>';
                        echo '<td>R$ ' . $linha['VR_DESPESA_CONTRATADA'] . '</td>';
                        echo '</td>';
                    }
                }

                ?>

            </tbody>


        </table>
    </div>















    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>