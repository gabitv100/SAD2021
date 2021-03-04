<?php
$conexao = mysqli_connect("localhost", "Viwer", "123456", "sad");
if (mysqli_connect_errno()) {
    printf("Conecto não: %s\n", mysqli_connect_error());
    exit();
}

if (isset($_GET['municipio']) && isset($_GET['cargo'])) {
    $query = "SELECT * FROM `fato` WHERE Municipio LIKE '$_GET[municipio]' and Cargo Like '$_GET[cargo]' ORDER BY `fato`.`DespesaTotal` DESC";
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
                    <a class="nav-link " href="despesasMunicipio.php">Despesas Por Município</a>
                    <a class="nav-link active" href="despesasPartido.php">Por Partido</a>
                    <a class="nav-link " href="despesasCandidato.php">Por Canditatos</a>

                </div>
            </div>
        </div>
    </nav>

    <div class="container">

        <hr>
        <div class="row">
            <form method="get" action="despesasCandidato.php">
                <div class="col-sm-5 ">
                    <select class="form-select" aria-label="municipio" name="municipio">


                        <?php
                        $query2 = "SELECT NM_UE as Municipio, SG_UE as Codigo FROM `ds_candidato` WHERE SG_UE NOT LIKE '-1' GROUP BY NM_UE ORDER BY NM_UE ASC";
                        if ($result2 = mysqli_query($conexao, $query2)) {
                            while ($linha = mysqli_fetch_assoc($result2)) {
                                echo '<option value="';
                                echo $linha['Municipio'] . '">' . $linha['Municipio'] . '</option>';
                            }
                        }
                        ?>


                    </select>
                </div>
                <div class="col-sm-5 ">
                    <select class="form-select" aria-label="cargo" name="cargo">
                        <option value="VEREADOR">Vereador</option>
                        <option value="PREFEITO">Prefeito</option>
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

        <h2>Despesas de campanha por candidato</h2>
        <h6>Grafico apresenta dados dos gastos de campanha declarados ao TRE-MT</h6>        
        <h6>Barras verdes indicam candidato eleito</h6>
        <h6>Barras vermelhas indicam candidato não-eleito</h6>
        <h6>Barras azuis indicam candidato suplente</h6>



        <canvas id="myChart" width="600" height="
        <?php
        if ($result = mysqli_query($conexao, $query)) {
            $count = 0;
            while ($linha = mysqli_fetch_assoc($result)) {
                $count += 30;
            }
            echo $count;
        }

        ?>
        "></canvas>
    </div>
    </div>

    <script src="Chart.js"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: [
                    <?php

                    if ($result = mysqli_query($conexao, $query)) {
                        while ($linha = mysqli_fetch_assoc($result)) {
                            echo '\'' . $linha['Nome'] . '\',';
                        }
                    }


                    ?>

                ],
                datasets: [{
                    label: 'Despesas',
                    data: [
                        <?php

                        if ($result = mysqli_query($conexao, $query)) {
                            while ($linha = mysqli_fetch_assoc($result)) {
                                echo  $linha['DespesaTotal'] . ', ';
                            }
                        }


                        ?>
                    ],
                    backgroundColor: [
                        <?php

                        if ($result = mysqli_query($conexao, $query)) {
                            while ($linha = mysqli_fetch_assoc($result)) {
                                $cor = 'rgb(250, 10, 10)';
                                if ($linha['Situacao'] == 'ELEITO POR Q') {
                                    $cor = 'rgb(0, 250, 0)';
                                } else if ($linha['Situacao'] == 'ELEITO POR M'  || $linha['Situacao'] == 'ELEITO' || $linha['Situacao'] == '2º TURNO') {
                                    $cor = 'rgb(10, 150, 100)';
                                } else if ($linha['Situacao'] == 'SUPLENTE') {
                                    $cor = 'rgb(80, 80, 230)';
                                }
                                echo '\'' . $cor . '\',';
                            }
                        }


                        ?>


                    ]

                }]
            },

            options: {

                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each horizontal bar to be 2px wide
                elements: {
                    rectangle: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: false,
                    text: 'Despesas'
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>