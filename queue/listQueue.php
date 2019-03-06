<?php
//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

$query = null;
?>

    <!-- TABLE | //#F47C48-->
    <div class="table-responsive">
    <table class="table table-striped table-hover" id="queueTable">
    <thead style="background: #9b9b9b">
    <tr>
        <th class='text-center'>Fila:</th>
        <th class='text-center'>Nome:</th>
        <th class='text-center'>Musica:</th>
    </tr>
    </thead>
    <tbody>

<?php
//====================================================
// LISTA AS MUSICAS DA FILA
//====================================================
$sql = "SELECT * FROM QUEUE ORDER BY Q_ID ASC";
$query = mysqli_query($con, $sql);

$arrayQueue = [];
$pedido = null;

if ($query != false) {
    while ($rows = mysqli_fetch_array($query)) {
        $pedido = $rows;
        array_push($arrayQueue, $pedido);
    }

    //====================================================
    // LOOP NOS PEDIDOS
    //====================================================
    if (!empty($arrayQueue)) {
        //====================================================
        // REGRA DE PREFERENCIA
        //====================================================
        $orderedArray = [];

        //Q_ID, Q_USER_ID, Q_NAME, Q_COD_MUSIC, Q_MUSIC, Q_DATE, Q_ORDERS

        //ARRAY PRIMEIRO PEDIDO E DEMAIS
        $arrayPrimeiro = [];
        $arrayDemais = [];
        $p = 0;
        $d = 0;
        for ($i = 0; $i < sizeof($arrayQueue); $i++) {
            if ($arrayQueue[$i][6] == 1) {
                $arrayPrimeiro[$p] = $arrayQueue[$i];
                $p++;
            } else {
                $arrayDemais[$d] = $arrayQueue[$i];
                $d++;
            }
        }

        $totalSize = sizeof($arrayPrimeiro) + sizeof($arrayDemais);

        //REORDENAR (2 PRIMEIRO 1 DEMAIS)
        $count = 0;
        $p = 0;
        $d = 0;
        $o = 0;
        for ($i = 0; $i < $totalSize; $i++) {
            if ($count < 2) {
                if (!empty($arrayPrimeiro[$p])) {
                    $orderedArray[$o] = $arrayPrimeiro[$p];
                    $p++;
                    $o++;
                    $count++;
                } elseif (!empty($arrayDemais[$d])) {
                    $orderedArray[$o] = $arrayDemais[$d];
                    $d++;
                    $o++;
                }
            } else {
                $count = 0;
                if (!empty($arrayDemais[$d])) {
                    $orderedArray[$o] = $arrayDemais[$d];
                    $d++;
                    $o++;
                } elseif (!empty($arrayPrimeiro[$p])) {
                    $orderedArray[$o] = $arrayPrimeiro[$p];
                    $p++;
                    $o++;
                }
            }
        }

        //DIVIDE EM ARRAYS DE TRES E CHECK REPETICAO DE USERS NELES
        $arrayQueue = array_chunk($orderedArray, 3);
        $sizeArrays = sizeof($arrayQueue);

       function checkRepeat($array, $id){
           $position = null;
           if(!empty($array[0]) && !empty($array[1]) && $array[0][2] == $array[1][2]){
               $position = 0;
           }elseif (!empty($array[0]) && !empty($array[2]) && $array[0][2] == $array[2][2]){
               $position = 1;
           }elseif(!empty($array[1]) && !empty($array[2]) && $array[1][2] == $array[2][2]){
               $position = 2;
           }
           return $resp[$id] = $position;
       }

       $isRepeated = [];
       for($i=0; $i < $sizeArrays; $i++){
           array_push($isRepeated, checkRepeat($arrayQueue[$i], $i));
       }

       //TROCAR REPETIDO PELO PRIMEIRO DO PROXIMO ARRAY
       for($i=0; $i < $sizeArrays; $i++){
           if($isRepeated[$i] >= 0 && !empty($arrayQueue[$i+1])){
               if(!empty($arrayQueue[$i][$isRepeated[$i]]) ){
                   $aux = $arrayQueue[$i][$isRepeated[$i]];
                   $arrayQueue[$i][$isRepeated[$i]] = $arrayQueue[$i+1][0];
               }elseif (!empty($arrayQueue[$i][$isRepeated[$i-1]])){
                   $aux = $arrayQueue[$i][$isRepeated[$i-1]];
                   $arrayQueue[$i][$isRepeated[$i-1]] = $arrayQueue[$i+1][0];
               }else{
                   $aux = $arrayQueue[$i][$isRepeated[$i-2]];
                   $arrayQueue[$i][$isRepeated[$i-2]] = $arrayQueue[$i+1][0];
               }
               $arrayQueue[$i+1][0] = $aux;
           }
       }

        $orderedArray = [];
        foreach($arrayQueue as $arr)
        {
            $orderedArray = array_merge($orderedArray , $arr);
        }

        $checkRpt = sizeof($orderedArray)-1;

        for ($i=1; $i < sizeof($orderedArray)-1; $i++){
            if(strcmp($orderedArray[$i][2], $orderedArray[$i-1][2]) == 0){
                $aux = $orderedArray[$i];

                while(strcmp($orderedArray[$i][2], $orderedArray[$checkRpt][2]) == 0){
                    $checkRpt--;
                }

                $orderedArray[$i] = $orderedArray[$checkRpt];
                $orderedArray[$checkRpt] = $aux;
                $checkRpt = sizeof($orderedArray)-1;
            }
        }

        for ($i = 0; $i < sizeof($orderedArray); $i++) {
            $pedido = $orderedArray[$i];
            $color = $i % 2 == 0 ? "#FFFFFF" : "#D8D8D8";
            ?>
            <tr id="pedido<?php echo $i ?>" style="background: <?php echo $color ?>">
                <td align="center"><?php echo $i + 1 ?></td>
                <td align="center"><?php echo strtoupper($pedido[2]) ?></td>
                <td align="center"><?php echo $pedido[4] ?></td>
            </tr>
        <?php
        }
    }else{
    ?>
        <script>
            $('#emptyQueue').append('<label>Sem pedidos na fila!</label>');
        </script>
        <?php
    }
} else {
    echo 'NOK';
}
$con->close();
