<?php


class Pasticho {

    public function tiempoDeCoccionPrevisto() {

    return 40;
    }

    public function tiempoCoccionRestante($tiempoCoccion) {
       
    return  $this->tiempoDeCoccionPrevisto() - $tiempoCoccion ;
    }

    public function tiempoTotalPreparacion($capaPasticho) {
          return $capaPasticho * 2;
    }

    public function tiempoTotalTranscurrido($capaPasticho,$totalMinutosHorno) {
         $this->tiempoTotalPreparacion($capaPasticho) + $totalMinutosHorno;
    }

    public function alarma() {
        return "TING! listo!";
    }

}

$pasticho = new Pasticho();

if ($pasticho->tiempoCoccionRestante(40) === 0) {
 echo $pasticho->alarma();
} else {
  echo "Aun falta para el pasticho";
}