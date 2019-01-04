<?php

    if(!empty($_POST)){
        $lang = 'eng';
        if(isset($_POST['lang'])){
            $lang = $_POST['lang'];
        }

        $format = 'pdf';
        if(isset($_POST['format'])){
            $format = $_POST['format'];
        }

        $seed = 'fcjhCjhwvSjbeivhtyceT';
        $secretKey = sha1(uniqid($seed . mt_rand(), true));

        $relativePath = '/files/' . date('Y-m-d') . '-output/' . $secretKey;
        $path = __DIR__ . $relativePath;
        if(!file_exists($path)){
            mkdir($path, 0777, true);
        }

        $filename = '';

        foreach($_POST['files'] as $file){
            $args = [
                'file' => curl_file_create(realpath($file['path']), $file['type'], $file['name'])
            ];
            
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
            
            $filename = substr($file['name'], 0, strrpos($file['name'], '.'));
            
            file_put_contents($path . '/' . $filename . '.' . $format, $file_array[2]);

            //unlink(realpath($file['path']));
        }

        if(count($_POST['files']) > 1){
            $path = realpath($path);

            $zip = new ZipArchive();
            $zipName = '/' . date('Y-m-d H_i_s') .'-archive.zip';
            $zip->open($path. $zipName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
            foreach ($files as $name => $file)
            {
                if ($file->isDir()) {
                    flush();
                    continue;
                }
                
                $filePath = $file->getRealPath();
                $relPath = substr($filePath, strlen($path) + 1);
                
                $zip->addFile($filePath, $relPath);
            }
            $zip->close();

            $downloadFile = $relativePath . $zipName;
            
        } else {
            $downloadFile = $relativePath . '/'. $filename . '.pdf';
        }        
        
        echo $downloadFile;
        exit;
    }

?>
