<?php
class M_Talleres extends \DB\SQL\Mapper {

    public function __construct(){
        parent::__construct( \Base::instance()->get('DB'), 'talleres' );
    }

}
