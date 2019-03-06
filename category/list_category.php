<?php
session_start();
$root = '../';
$arraySongs = [];
$category = !empty($_REQUEST['category']) ? $_REQUEST['category'] : null;

//@ REMOVE OS WARNINGS
$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

//====================================================
// LISTA AS MUSICAS DA CATEGORIA
//====================================================
$tbl_name = $category;
$query = null;

if ($category == 'NAC' && !isset($_SESSION['nac_list'])) {
    $sql = 'SELECT * FROM ' . $tbl_name . ' ORDER BY N_ID ASC';
    $query = mysqli_query($con, $sql);
} elseif ($category == 'INTER' && !isset($_SESSION['inter_list'])) {
    $sql = 'SELECT * FROM ' . $tbl_name . ' ORDER BY I_ID ASC';
    $query = mysqli_query($con, $sql);
}

?>

<!-- TABLE | //#F47C48-->
<div class="table-responsive">
    <table class="table table-striped table-hover" id="categoryTable">
        <thead style="background: #9b9b9b">
        <tr>
            <th class='text-left'>Código:</th>
            <th class='text-left'>Artista:</th>
            <th class='text-left'>Música:</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $i = 0;

        if(empty($query)){
            if($category == 'NAC') $_SESSION['nac_list'] = $query;
            else $_SESSION['inter_list'] = $query;
        }

        if ($query != false) {
            while ($rows = mysqli_fetch_array($query)) {
                $song = $rows;
                array_push($arraySongs, $song);

                //====================================================
                // LOOP NAS MUSICAS
                //====================================================
                $color = $i % 2 == 0 ? "#FFFFFF" : "#D8D8D8";
                ?>
                <tr id="song<?php echo $i ?>" style="background: <?php echo $color ?>">
                    <td align="left"><?php echo $song[0] ?></td>
                    <td align="left"><?php echo $song[1] ?></td>
                    <td align="left"><?php echo $song[2] ?></td>
                </tr>
                <?php
                $i++;
            }
            $con->close();
        }
        ?>
