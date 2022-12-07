<?php 

class Talleres_ctrl{
    public $M_Taller = null;

    public function __construct(){
        
        $this->M_Taller = new M_Talleres();
       
    }

    //Funcion para consultar una id
    public function consultar($f3){
        $taller_id = $f3->get('PARAMS.taller_id');
        $this->M_Taller->load(['id = ?',$taller_id]);

        $msg = "";
        $item = array();

        if($this->M_Taller->loaded() > 0) {
            $msg = "Alumno encontrado";
            $item = $this->M_Taller->cast();
        }else{
            $msg = "Alumno no encontrado";
        }

        echo json_encode([ 
            'Mensaje' => $msg,
            'info' => [
                'item' => $item
            ]
        ]);
    }

    //Funcion para listar toda la tabla 
    public function listado($f3){
        $result = $this->M_Taller->find();
        $items = array();

        foreach($result as $taller){
            $items[] = $taller->cast();
        }
        echo json_encode([ 
            'Mensaje' => count($items) > 0 ? '' : 'Aun no hay registros para mostrar',
            'info' => [
                'items' => $items,
                'total' => count($items)
            ]
        ]);
    }


}