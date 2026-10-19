<?php

class AssetSanitizer
{

    public function getExtension(string $file): string
    {

        /*
        1- Eliminar espacios en blanco.
        2-Verificar si el archivo tiene extension (.) y ejecutar un proceso y si no lo tiene devolver bin
        3- Si es verdadero y tiene .extension, eliminar todo lo que este antes de la extension (almacenarlo)
        pero mostrar solo la extension y guardarlo en una nueva variable.
        4. retornar la nueva variable
        5. probar todos los casos hasta romper  
        6. retornar bin si no tiene extension
         */
        $file = trim($file);
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if (!empty($extension)) {
            return $extension;
        } else {
            $extension = "bin";
            return $extension;
        }

    }

    public function sanitizeBaseName(string $filename): string
    {
            $filename = trim($filename);
            $name = pathinfo($filename, PATHINFO_FILENAME);
            $patron = '/\W+/u';

            $fileclear = preg_replace($patron, '_', $name);

            return $fileclear;
    }
        

}




$fileOne = new AssetSanitizer();
//echo $fileOne->getExtension("informe.docx");
echo $fileOne->sanitizeBaseName("docuen.png");

