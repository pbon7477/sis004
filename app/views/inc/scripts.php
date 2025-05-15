
<?php 
//Que se incluyan los script, solo si se inicio session
if( isset($_SESSION['id']) ) :
?>

<script src="<?= APP_URL;?>/app/views/js/ajax.js"></script>
<script src="<?= APP_URL;?>/app/views/js/main.js"></script>
<script src="<?= APP_URL;?>/app/views/js/script.js"></script>


<?php 
endif;
?>
