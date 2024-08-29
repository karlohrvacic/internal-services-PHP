<!DOCTYPE html>
<html lang="hr">
<head>
    <title>Printanje</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="container-fluid main">
        <div class="infobox p-3">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Odaberi dokument za print:</label>
                    <input class="form-control form-control-lg" id="formFile" type="file" name="file" required>
                </div>
                <div class="mb-3">
                    <label for="brKopija" class="form-label">Broj kopija:</label>
                    <input class="form-control form-control-lg" id="brKopija" type="number" name="brojKopija" value="1" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="nacinPrinta" class="form-label">Način printanja:</label>
                    <select name="nacinPrinta" id="nacinPrinta" class="form-select" aria-label="Način printanja:">
                        <option value="1" selected>Obostrano (po dugom rubu)</option>
                        <option value="2">Jednostrano</option>
                        <option value="3">Obostrano (po kratkom rubu)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Selektivan odabir stranica (za sve 0-0):</label>
                    <div class="row">
                        <div class="col">
                            <input class="form-control form-control-lg" id="dokumentOd" type="number" name="dokumentOd" value="0" min="0" placeholder="Od">
                        </div>
                        <div class="col">
                            <input class="form-control form-control-lg" id="dokumentDo" type="number" name="dokumentDo" value="0" min="0" placeholder="Do">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="submit" value="Printaj" name="upload" class="btn btn-primary">
                    <a href="index.html" class="btn btn-outline-secondary ms-2">Povratak na izbornik</a>
                </div>
            </form>
        </div>
    </div>
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
        if (isset($_FILES['file']) && move_uploaded_file($_FILES['file']['tmp_name'], $foldername.str_replace(' ', '_', $_FILES['file']['name']))) {
            $path = $foldername.str_replace(' ', '_', $_FILES['file']['name']);
        } else {
            echo "<div class='alert alert-danger'>Dokument nije podignut.</div>";
        }
        if($path && $nacinPrinta){
            echo "<div class='alert alert-info'>Printanje vjerojatno u tijeku</div>";
            if (exec("lp $path -n $brKopija -o sides=$nacinPrinta $ostaleOpcije")){
                unlink($path);
            }
        }
    }
    ?>
</body>
</html>
