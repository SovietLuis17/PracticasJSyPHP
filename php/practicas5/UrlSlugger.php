<?php

class UrlSlugger
{


    public function cleanSpaces(string $text): string
    {
        $text = trim($text);
        $text = str_replace("  ", " ", $text);
        return $text;
    }

    public function slugity(string $title): string
    {


        $title = $this->cleanSpaces($title);
        $title = mb_strtolower($title, 'UTF-8');
        $title = str_replace(" ", "-", $title);
        if ($title == "") {
            return $title = "sin-titulo";
        } else {
            return $title;
        }

    }

}


$text = new UrlSlugger();
//echo $text->cleanSpaces(" Holaaa     mundo   holaa  ");
echo "Usando el metodo slugity : " . $text->slugity("   curso DE PROGRAMACION      PHP Y PRACTICAS   ");




/*
SOLUCION PROPUESTA POR LA IA : 
<?php

class UrlSlugger
{
    public function cleanSpaces(string $text): string
    {
        // trim() quita espacios al inicio y al final
        $text = trim($text);
        
        // preg_replace con /\s+/u reemplaza 1 o más espacios intermedios por uno solo
        return preg_replace('/\s+/u', ' ', $text);
    }

    public function slugify(string $title): string
    {
        $cleaned = $this->cleanSpaces($title);

        // Si la cadena queda vacía tras limpiar espacios, retornamos la alternativa por defecto
        if ($cleaned === "") {
            return "sin-titulo";
        }

        // Convertimos a minúsculas respetando UTF-8
        $lower = mb_strtolower($cleaned, 'UTF-8');

        // Reemplazamos los espacios individuales por guiones
        return str_replace(" ", "-", $lower);
    }
}

// Bloque de pruebas
$slugger = new UrlSlugger();

echo $slugger->slugify("   curso DE PROGRAMACION      PHP Y PRACTICAS   ") . "<br>";
// Resultado: "curso-de-programacion-php-y-practicas"

echo $slugger->slugify("        ") . "<br>";
// Resultado: "sin-titulo"









*/


