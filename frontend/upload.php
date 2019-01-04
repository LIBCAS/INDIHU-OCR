<?php

    if (!empty($_FILES)) {
        $seed = 'fcjhCjhwvSjbeivhtyceT';
        $secretKey = sha1(uniqid($seed . mt_rand(), true));

        $relativePath = '/files/' . date('Y-m-d') . '-input';
        $path = __DIR__ . $relativePath;
        if(!file_exists($path)){
            mkdir($path, 0777, true);
        }

        $filenameWithPath = $path . '/' . $secretKey . '_' . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $filenameWithPath); 

        $result = [          
            'path' => $filenameWithPath,
            'url' => $relativePath . '/' . $secretKey . '_' . $_FILES['file']['name']
        ];

        $json = json_encode($result);

        header('Content-type:application/json;charset=utf-8');
        ob_get_clean();
        echo $json; exit;
    }

?>