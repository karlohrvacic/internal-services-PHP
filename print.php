<!DOCTYPE html>
<html lang="hr">
  <head>
    <title>Printanje</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
	<div class="container-fluid main">
		<div class="infobox p-3">
			<form action="" method="post" enctype="multipart/form-data">
				<label for="formFileLg" class="form-label">Odaberi dokument za print:</label>
			  <input class="form-control form-control-lg" id="formFile files" type="file" name="file">

                <label for="brKopija" class="form-label">Broj kopija:</label>
			  <input class="form-control form-control-lg" id="brKopija" type="number" name="brojKopija" value="1" min="1">

                <label for="brKopija" class="form-label">Način prinatanja:</label>
                <select name="nacinPrinta" class="form-select" aria-label="Način printanja:">
                    <option value="1" selected>Obostrano (po dugom rubu)</option>
                    <option value="2">Jednostrano</option>
                    <option value="3">Obostrano (po kratkom rubu)</option>
                </select>

                <label for="brKopija" class="form-label">Selektivan odabir stranica (za sve 0-0):</label>
                <input class="form-control form-control-lg" id="brKopija" type="number" name="dokumentOd" value="0" min="0">
                <input class="form-control form-control-lg" id="brKopija" type="number" name="dokumentDo" value="0" min="0">

			  <input type="Submit" value="Printaj" name="upload" class="btn btn-primary m-2" />
			</form>
			<a href="index.html"><button class="btn btn-outline-secondary">povratak na izbornik</button></a>
		</div>
  </body>
</html>
<?php
	if(isset($_POST['upload'])){
        $foldername = "files/print/";
        $path = null;

        $ostaleOpcije = '';

        $brKopija = $_POST['brojKopija'];
        $dokumentOd = $_POST['dokumentOd'];
        $dokumentDo = $_POST['dokumentDo'];

        $nacinPrinta = null;

        switch ($_POST['nacinPrinta']) {
            case 1:
                $nacinPrinta = 'two-sided-long-edge';
                break;
            case 2:
                $nacinPrinta = 'one-sided';
                break;
            case 3:
                $nacinPrinta = 'two-sided-short-edge';
                break;
        }

        if ($dokumentDo > $dokumentOd){
            if ($dokumentOd == 0){
                $dokumentOd = 1;
            }
            $ostaleOpcije .= "-P $dokumentOd-$dokumentDo";
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $foldername.$_FILES['file']['name'])) {
            $path = $foldername."'".$_FILES['file']['name']."'";
        } else {
            echo "Dokument nije podignut.";
        }
        if($path && $nacinPrinta){
            echo "Printanje vjerojatno u tijeku";
            if (exec("lp $path -n $brKopija -o sides=$nacinPrinta $ostaleOpcije")){
            unlink($path);
            }
        }
    }
?>
