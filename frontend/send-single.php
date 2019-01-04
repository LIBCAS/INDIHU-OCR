<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>INDIHU OCR</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/dropzone.min.css" rel="stylesheet">
  </head>

  <body style="align-items: normal; padding-top: 20px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-3"><a href="/ocr-web" style="color: black; text-decoration: none">INDIHU OCR</a></h1>
            </div>
        </div>
    
    <?php

    if(!empty($_POST)){
        
        if(isset($_POST['fileToSend'])){
            $lang = 'eng';
            if(isset($_POST['lang'])){
                $lang = $_POST['lang'];
            }

            $format = 'pdf';
            if(isset($_POST['format'])){
                $format = $_POST['format'];
            }

            $fileArray = json_decode($_POST['fileToSend']);

            $seed = 'fcjhCjhwvSjbeivhtyceT';
            $secretKey = sha1(uniqid($seed . mt_rand(), true));

            $path = __DIR__ . '/files/' . date('Y-m-d') . '-output/' . $secretKey;
            if(!file_exists($path)){
                mkdir($path, 0777, true);
            }
            
            foreach($fileArray as $file){
                $args = [
                    'file' => curl_file_create(realpath($file->path), $file->type, $file->name)
                ];
            ?>
                <div class="row">
                    <div class="col-6">
                        <h1 class="h4 mb-2 font-weight-normal">Zdroj</h1>
                        <img src="<?php echo '/ocr-web' . $file->url;?>" width="500px">
                    </div>
            <?php
                
                $curl = curl_init('http://127.0.0.1:8090/ocr?lang=' . $lang . '&format=' . $format);
                // $curl = curl_init('http://inqooltest-arclib.libj.cas.cz:8080/ocr?lang=' . $lang . '&format=' . $format);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $args);
            
                $response = curl_exec($curl);
				
                $file_array = explode("\n\r", $response, 3);     
                $header_array = explode("\n", $file_array[1]);
                foreach($header_array as $header_value) {
                    $header_pieces = explode(':', $header_value);
                    if(count($header_pieces) == 2) {
                        $headers[$header_pieces[0]] = trim($header_pieces[1]);
                    }
                }
                
                $pos = strpos($file_array[1], 'filename=') + 9;
                $filename = substr($file_array[1], $pos, (strpos($file_array[1], PHP_EOL, $pos)) - $pos);
                
                ?> 
                        <div class="col-6">
                            <h1 class="h4 mb-2 font-weight-normal">Výsledek</h1>
                            <form method="post" action="">
                                <textarea name="content" rows="27" cols="80" class="mb-2" style="width: 100%"> <?php echo $file_array[2]; ?> </textarea> 
                                <input type="hidden" name="fileToRemove" value="<?php echo $file->path;?>">
                                <button id="send" class="btn btn-lg btn-primary btn-block" type="submit">Stáhnout</button>
                                <div id="new" class="mt-2" style="text-align: center;" title="Pozor, stiskem ztratíte výsledek aktuální konverze!">
                                    <a href="/ocr-web">Nová konverze</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <p class="mt-3 mb-3 text-muted">Projekt INDIHU realizuje Akademie věd ČR, Národní knihovna ČR, Archeologický ústav AV ČR (Brno), Archeologický ústav AV ČR (Praha), Etnologický ústav AV ČR, Filozofický ústav AV ČR, Ústav pro českou literaturu AV ČR, Ústav dějin umění AV ČR.</p>
                    </div>
                    </div>
                    
                    
                <?php
                
            }
            
        } else {
            unlink($_POST['fileToRemove']);

            header('Expires: 0'); // no cache
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
            header('Cache-Control: private', false);
            header('Content-type: text/plain');
            header('Content-Disposition: attachment; filename="' . date('Y-m-d H_i_s') . '-result.txt"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . strlen($_POST['content']));
            header('Connection: close');

            ob_clean();
            ob_start();
            echo $_POST['content']; exit;
            
        }
    } else {
        header("Location: /ocr-web");
        exit();
    }

?>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="js/jquery-slim.min.js"><\/script>')</script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<style>
    
    img:hover {
        position: relative;
        -webkit-transform: scale(1.4);
        -ms-transform: scale(1.4);
        -o-transform: scale(1.4);
        transform: scale(1.4);
        z-index: 1000;
    }
    * {
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -ms-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
        transition: all 0.5s ease-in-out;
    }
</style>

</body>
</html>
