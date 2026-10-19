<?php

class DataMasker
{


    public function maskEmail(string $email): string
    {
        $email = trim($email); // 1. Limpiar caracteres en blanco

        // Validación: Si no es un correo válido o es muy corto, devolver original
        if (!str_contains($email, '@') || strlen(strstr($email, '@', true)) <= 2) {
            return $email;
        }

        $back = strstr($email, "@");          // 2. Obtener el final (@gmail.com)
        $start = strstr($email, "@", true);   // 3. Obtener el principio (usuario) -> ¡Corregido!

        $letras = str_split($start);          // 4. Convertir en arreglo

        $primera_clave = array_key_first($letras);
        $ultima_clave = array_key_last($letras);

        // 5. Recorrer con el símbolo & para modificar por referencia 
        foreach ($letras as $clave => &$valor) {
            if ($clave !== $primera_clave && $clave !== $ultima_clave) {
                $valor = "*";
            }
        }
        unset($valor); // Limpiar referencia

        $start_enmascarado = implode("", $letras); // 6. Volver a unir el texto

        return $start_enmascarado . $back; // 7. Retornar el correo completo
    }



}

$n = new DataMasker();
echo $n->maskEmail("luissoliveros17@gmail.com");
