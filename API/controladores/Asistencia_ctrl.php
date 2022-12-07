<?php 

class Asistencia_ctrl{
    public $M_Asistencia = null;

    public function __construct(){
        
        $this->M_Asistencia = new M_Asistencia();
       
    }

    //Funcion para crear un asistencia
    public function crear($f3){
        $date = getdate();
        $fecha = $date['mday']."-".$date['mon']."-".$date['year'];

        
        $this->M_Asistencia->set('id_usuario',$f3->get('POST.id_usuario'));
        $this->M_Asistencia->set('id_taller', $f3->get('POST.id_taller'));
        $this->M_Asistencia->set('fecha',  $fecha);
        $this->M_Asistencia->save();
        
    

        //echo $this->M_Alumno->get('id');

         echo json_encode([ 
            'Mensaje' => 'SE CREO LA ASISTENCIA',
            'info' => [
                'id' => $this->M_Asistencia->get('id')
            ]
        ]);
    }

    //Funcion para consultar una id
    public function consultar($f3){
        $asistencia_id = $f3->get('PARAMS.asistencia_id');
        $this->M_Aistencia->load(['id = ?',$asistencia_id]);

        $msg = "";
        $item = array();

        if($this->M_Asistencia->loaded() > 0) {
            $msg = "Asistencia encontrado";
            $item = $this->M_Asistencia->cast();
        }else{
            $msg = "Asistencia no encontrado";
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

        $params = [];
        if(!empty($f3->get('POST.texto'))){
            $params = ['id= ?' , $f3->get('POST.texto')];
        }
        $this->M_Asistencia->usuario = "SELECT nombre FROM usuarios WHERE id_usuario = asistencia.id_usuario ";
        $this->M_Asistencia->taller = "SELECT taller FROM talleres WHERE id_nombre = asistencia.id_taller ";
        
        $result = $this->M_Asistencia->find($params);


        //OBTENER FECHA
        $fechactual = getdate();

        $items = array();

        foreach($result as $asistencia){
            $items[] = $asistencia->cast();
        }

        echo json_encode([ 
            'Mensaje' => count($items) > 0 ? '' : 'Aun no hay registros para mostrar',
            'info' => [
                'items' => $items,
                'id1' => $items[0]['id1'],
                'total' => count($items),
                'alumno' => $alumno
                
            ]
        ]);
    }

    //Funcion para eliminar un registro
    public function eliminar($f3){
        $asistencia_id = $f3->get('PARAMS.asistencia_id');
        $this->M_Asistencia->load(['id = ?',$asistencia_id]);

        $msg = "";
    

        if($this->M_Asistencia->loaded() > 0) {
            $msg = "Asistencia eliminado";
            $item = $this->M_Asistencia->erase();
        }else{
            $msg = "Asistencia no encontrado";
        }

        echo json_encode([ 
            'Mensaje' => $msg,
            'info' => []
        ]);
    }

}