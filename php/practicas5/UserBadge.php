<?php


class UserBadge {

 public function getFirstName(string $fullName) :string {
   $fullName = trim($fullName);
   $fullName = preg_replace('/\s+/u', ' ', $fullName);
   $fullName = mb_convert_case($fullName, MB_CASE_TITLE, "UTF-8");
   $fullName = explode(" ",$fullName);
   return $fullName[0];
 }

 public function getLastName(string $fullName) :string {
    $fullName = preg_replace('/\s+/u', ' ', $fullName);
    if ($fullName == "" || $fullName == " ") {
    return $fullName = "X";
    } else {
        $fullName = $this->getFirstName($fullName);
        return $fullName;
    }
 }

 public function getGenerateUserName(string $fullName, int $birthYear) :string {
  $fullName = trim($fullName);
  $fullName = preg_replace('/\s+/u', ' ', $fullName);
  $fullName = explode(" ",$fullName);
  $firstLetter = mb_substr($fullName[0],0,1,'UTF-8');
  //$lastname =  mb_strtolower($fullName[1], 'UTF-8');
  $lastname = $this->getLastName($fullName[1]);
 
  if (mb_strlen($birthYear,'UTF-8') <= 4) {
   $birthYear = mb_substr($birthYear,2,4,'UTF-8');
   return  mb_strtolower($firstLetter.=$lastname.=$birthYear, 'UTF-8');
  }
  else {
    $birthYear = mb_substr($birthYear,3,5,'UTF-8');
   return  mb_strtolower($firstLetter.=$lastname.=$birthYear, 'UTF-8');
  }

 }

  public function renderBadge(string $fullName, int $birthYear, string $role) :string {
  $newNameUser = $this->getGenerateUserName($fullName,$birthYear);
   return <<<EOD
+--------------------------+

| USER: "$newNameUser"     |
| ROLE: [$role]            |
+--------------------------+
EOD;
  }


}

$n = new UserBadge();
echo $n->getGenerateUserName("Luis Oliveros",1996);
echo "<br> <pre>".$n->renderBadge("Luis Oliveros",1996,"ADMIN")."</pre>";

/*

RESPUESTA DE LA IA : 
<?php

class UserBadge
{
    public function getFirstName(string $fullName): string
    {
        $cleaned = trim(preg_replace('/\s+/u', ' ', $fullName));
        if ($cleaned === '') {
            return '';
        }
        $parts = explode(' ', $cleaned);
        return $parts[0];
    }

    public function getLastName(string $fullName): string
    {
        $cleaned = trim(preg_replace('/\s+/u', ' ', $fullName));
        $parts = explode(' ', $cleaned);

        // Si existe un segundo elemento en el arreglo y no está vacío, es el apellido
        if (isset($parts[1]) && $parts[1] !== '') {
            return $parts[1];
        }

        // Si no hay apellido, devolvemos la alternativa por defecto
        return 'X';
    }

    public function generateUsername(string $fullName, int $birthYear): string
    {
        // 1. Obtenemos el nombre y apellido usando los métodos creados
        $firstName = $this->getFirstName($fullName);
        $lastName = $this->getLastName($fullName);

        // 2. Extraemos la primera letra del nombre
        $firstLetter = mb_substr($firstName, 0, 1, 'UTF-8');

        // 3. Extraemos los últimos 2 dígitos del año de nacimiento
        $yearDigits = substr((string)$birthYear, -2);

        // 4. Construimos el username en minúsculas
        $username = $firstLetter . $lastName . $yearDigits;
        return mb_strtolower($username, 'UTF-8');
    }

    public function renderBadge(string $fullName, int $birthYear, string $role): string
    {
        $username = $this->generateUsername($fullName, $birthYear);
        
        return <<<EOD
+--------------------------+
| USER: {$username}         |
| ROLE: [{$role}]            |
+--------------------------+
EOD;
    }
}

// Bloque de pruebas
$badge = new UserBadge();

// Prueba con nombre completo
echo "Username 1: " . $badge->generateUsername("Luis Oliveros", 1996) . "<br>"; 
// Resultado: "loliveros96"

// Prueba con un solo nombre (sin apellido)
echo "Username 2: " . $badge->generateUsername("Carlos", 1995) . "<br>"; 
// Resultado: "cx95"

// Prueba de renderizado
echo "<pre>" . $badge->renderBadge("Luis Oliveros", 1996, "ADMIN") . "</pre>";
*/