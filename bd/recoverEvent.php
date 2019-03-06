<?php
session_start();

//parametros = {'data': data, 'local': local};
$data = $_REQUEST['data'];
$hora = $_REQUEST['hora'];
$local = $_REQUEST['local'];

$datetime = $data . ' ' . $hora;
$dt = DateTime::createFromFormat("d/m/Y G:i", $datetime);
$timestamp = $dt->getTimestamp();

$dt->setTimestamp($timestamp);
$datetime = $dt->format('d/m/Y H:i');

//====================================================
// SETA OS VALORES NA MODAL
//====================================================
?>
<script>
    $('#datepicker').val(<?php echo $data?>);
    $('#timepicker').val(<?php echo $hora?>);
    $("#local").val(<?php echo $local?>);
</script>
