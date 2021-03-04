<?php
$conexao = mysqli_connect("localhost", "Viwer", "123456", "sad");
if (mysqli_connect_errno()) {
    printf("Conecto não: %s\n", mysqli_connect_error());
    exit();
}

if (isset($_GET['partido']) && $_GET['partido'] != 'TODOS OS PARTIDOS') {
    $query = "SELECT NM_UE as 'Municipio', SUM(VR_DESPESA_CONTRATADA) as 'Valor' FROM `ds_candidato` WHERE NR_PARTIDO LIKE $_GET[partido] GROUP BY MUNICiPIO ORDER BY VALOR DESC";
} else {
    $query = "SELECT NM_UE as 'Municipio', SUM(VR_DESPESA_CONTRATADA) as 'Valor' FROM `ds_candidato`GROUP BY MUNICiPIO ORDER BY VALOR DESC";
}

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Município', 'Valor R$'],
                <?php
                if ($result = mysqli_query($conexao, $query)) {
                    while ($linha = mysqli_fetch_assoc($result)) {
                        echo '["';
                        echo $linha['Municipio'] . '",' . $linha['Valor'] . '],';
                    }
                }

                ?>


            ]);

            var options = {
                title: 'Despesas por partido',
                width: 1000,
                height: 2800,
                legend: {
                    position: 'none'
                },
                chart: {
                    title: 'Despesas por partido',
                    subtitle: 'Soma do total declarado de todos os candidatos por partido'
                },
                bars: 'horizontal', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: {
                            side: 'top',
                            label: 'Despesas'
                        } // Top x-axis.
                    }
                },
                bar: {
                    groupWidth: "90%"
                }
            };

            var chart = new google.charts.Bar(document.getElementById('top_x_div'));
            chart.draw(data, options);
        };
    </script>
    <title>Sistema SAD-UFMT 2020 - Gabriel Viana</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Analise de Despesas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link " aria-current="page" href="despesasTotais.php">Despesas Totais</a>
                    <a class="nav-link active " href="despesasMunicipio.php">Despesas Por Município</a>
                    <a class="nav-link " href="despesasPartido.php">Por Partido</a>
                    <a class="nav-link " href="despesasCandidato.php">Por Canditatos</a>

                </div>
            </div>
        </div>
    </nav>







    <!-- CONETUDO  -->


    <div class="container">

        <hr>
        <div class="row">
            <form method="get" action="despesasMunicipio.php">
                <div class="col-sm-10 ">
                    <select class="form-select" aria-label="municipio" name="partido">
                        <option selected>TODOS OS PARTIDOS</option>

                        <?php
                        $query2 = "SELECT NR_PARTIDO,NM_PARTIDO FROM `ds_candidato` WHERE NM_UE NOT LIKE '-1' GROUP BY NR_PARTIDO ORDER BY `ds_candidato`.`NM_PARTIDO` ASC";
                        if ($result2 = mysqli_query($conexao, $query2)) {
                            while ($linha = mysqli_fetch_assoc($result2)) {
                                echo '<option value="';
                                echo $linha['NR_PARTIDO'] . '">' . $linha['NM_PARTIDO'] . '</option>';
                            }
                        }
                        ?>


                    </select>
                </div>
                <div class="col-sm-2 ">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar
                    </button>
                </div>
            </form>

        </div>
        <hr>

        <div id="top_x_div" style="width: 900px; height: 500px;"></div>
    </div>
    </div>















    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>