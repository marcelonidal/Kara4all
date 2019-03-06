<?php
session_start();
$tipoUpload = $_REQUEST['tipoUpload'];

$target_dir = null;
$valid_extensions = null;

/* Getting file name */
$filename = null;
$new_dir = null;
$location = null;

function doUpload($baseUrl, $location, $valid_extensions){
    $uploadOk = "OK";
    $fileType = pathinfo($location,PATHINFO_EXTENSION);

    /* Check file extension */
    if( !in_array(strtolower($fileType),$valid_extensions) ) {
        $uploadOk = "NOK";
    }

    if($uploadOk == "NOK"){
        return "NOK";
    }else{
        /*Create Folder*/
        if(!file_exists($baseUrl)) mkdir($baseUrl);
        /* Upload file */
        if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
            return $location;
        }else{
            return "NOK";
        }
    }
}

//====================================================
// DESTINO DO UPLOAD UPLOAD
//====================================================
if ($tipoUpload == 'flyer') {
    $filename = $_FILES['file']['name'];
    $target_dir = "../img/flyers/";
    $valid_extensions = array("jpg","jpeg","png");
    /* Location */
    $location = $target_dir . $filename;

    $response = doUpload($target_dir, $location, $valid_extensions);
    echo json_encode($response);
} elseif ($tipoUpload == 'listas') {
    $target_dir = "../admin/listas/";

    //2 FILES
    $arrayResp = [];
    for($i=0; $i < 2; $i++){
        $filename = $_FILES["file" . ($i+1)]['name'];

        //nac_201812.csv
        $new_dir = substr($filename, 4, -4);
        $baseUrl = $target_dir . $new_dir . '/';
        $valid_extensions = array("csv");
        /* Location */
        $location = $target_dir . $new_dir . '/' . $filename;

        $_FILES['file'] = $_FILES["file" . ($i+1)];

        array_push($arrayResp, doUpload($baseUrl, $location, $valid_extensions));
    }
    echo json_encode($arrayResp);
}

?>
