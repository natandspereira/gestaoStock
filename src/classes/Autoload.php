<?php
spl_autoload_register(function ($className) {
     
    //  CAMINHO BASE DA PASTA ONDE ESTÃO AS CLASSES
    $base_dir = __DIR__ . '/';

    
    // MONTA O CAMINHO COMPLETO DA CLASSE
    $file = $base_dir . $className . '.php';

    if (file_exists($file)) {
        require_once $file;
    } else {
        throw new Exception("Arquivo para a classe {$className} não encontrado em {$file}");
    }
});
?>
