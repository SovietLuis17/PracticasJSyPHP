<?php

class HighSchoolSweetheart
{
    // CORRECCIÓN 1: Nombre exacto del método (firstLetter)
    public function firstLetter(string $name): string
    {
        $name = trim($name);
        return mb_substr($name, 0, 1, "UTF-8");
    }

    public function initial(string $name): string
    {
        // CORRECCIÓN 2: mb_strtoupper para asegurar la mayúscula de cualquier carácter
        $initial = $this->firstLetter($name);
        return mb_strtoupper($initial, "UTF-8") . ".";
    }

    public function initials(string $name): string
    {
        $parts = explode(" ", trim($name), 2);
        
        $nameOne = $this->initial($parts[0]);
        $nameTwo = isset($parts[1]) ? $this->initial($parts[1]) : "";
        
        return trim("$nameOne $nameTwo");
    }

    public function pair(string $sweetheart_a, string $sweetheart_b): string
    {
        $a = $this->initials($sweetheart_a);
        $b = $this->initials($sweetheart_b);
        
        // Formateamos la línea central para que siempre mida exactamente lo mismo
        // "     J. K.  +  M. B.     " tiene exactamente 5 espacios antes y después
        // El formato ideal de Exercism para la línea central espera esta estructura:
        $lineaCentral = "     $a  +  $b     ";
        
        // CORRECCIÓN 3: Plantilla ASCII con los espacios idénticos solicitados
        return <<<EOD
     ******       ******
   **      **   **      **
 **         ** **         **
**            *            **
**                         **
**$lineaCentral**
 **                       **
   **                   **
     **               **
       **           **
         **       **
           **   **
             ***
              *
EOD;
    }
}

// Bloque de pruebas en tu navegador
$h = new HighSchoolSweetheart();
echo "Inicial: " . $h->initial("maria") . "<br>";
echo "Iniciales: " . $h->initials("Jose perez") . "<br>";
echo "<pre>";
echo $h->pair("Blake Miller", "Riley Lewis");
echo "</pre>";
