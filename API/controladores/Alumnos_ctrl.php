<?php 

class Alumnos_ctrl{
    public $M_Alumno = null;

    public function __construct(){
        
        $this->M_Alumno = new M_Alumnos();
       
    }

    //Funcion para crear un alumno
    public function crear($f3){

        $this->M_Alumno->load(['nombre = ? OR email = ?', $f3->get('POST.nombre'),$f3->get('POST.email')]);

        
        if($this->M_Alumno->loaded()>0){
            echo json_encode([
                'mensaje' => 'Ya esxiste un alumno con ese nombre o correo que intenta registrar',
                'info' => [
                    'id' => $this->M_Alumno->get('id')
                ]
            ]);
        }else{
            $this->M_Alumno->set('email',    $f3->get('POST.email'));
            $this->M_Alumno->set('hashpass', $f3->get('POST.hashpass'));
            $this->M_Alumno->set('Nombre',   $f3->get('POST.Nombre'));
            $this->M_Alumno->set('Carrera',  $f3->get('POST.Carrera'));
            $this->M_Alumno->set('Matricula',$f3->get('POST.Matricula'));
            $this->M_Alumno->set('Grupo',    $f3->get('POST.Grupo'));
            $this->M_Alumno->set('Celular',  $f3->get('POST.Celular'));
            $this->M_Alumno->set('aType',    $f3->get('POST.aType'));
            $this->M_Alumno->save();
    
    
            //echo $this->M_Alumno->get('id');
    
             echo json_encode([ 
                'Mensaje' => 'ALUMNO CREADO',
                'info' => [
                    'id' => $this->M_Alumno->get('id')
                ]
            ]);
        }
    }

    //Funcion para consultar una id
    public function consultar($f3){
        $alumnos_id = $f3->get('PARAMS.alumno_id');
        $this->M_Alumno->load(['id = ?',$alumnos_id]);

        $msg = "";
        $item = array();

        if($this->M_Alumno->loaded() > 0) {
            $msg = "Alumno encontrado";
            $item = $this->M_Alumno->cast();
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
        $result = $this->M_Alumno->find();
        $items = array();

        foreach($result as $alumno){
            $items[] = $alumno->cast();
        }
        echo json_encode([ 
            'Mensaje' => count($items) > 0 ? '' : 'Aun no hay registros para mostrar',
            'info' => [
                'items' => $items,
                'total' => count($items)
            ]
        ]);
    }

    //Funcion para eliminar un registro
    public function eliminar($f3){
        $alumno_id = $f3->get('PARAMS.alumno_id');
        $this->M_Alumno->load(['id = ?',$alumno_id]);

        $msg = "";
    

        if($this->M_Alumno->loaded() > 0) {
            $msg = "Alumno eliminado";
            $item = $this->M_Alumno->erase();
        }else{
            $msg = "Alumno no encontrado";
        }

        echo json_encode([ 
            'Mensaje' => $msg,
            'info' => []
        ]);
    }

}