<?php

class ReportController extends DooController {

    public function excel() {
        //preg_split('/[,\-]/', $this->params['id_cliente'], -1, PREG_SPLIT_NO_EMPTY);
        $this->toJSON(array('excel' => true), true);
    }

    public function pdf() {
        //preg_split('/[,\-]/', $this->params['id_cliente'], -1, PREG_SPLIT_NO_EMPTY);
        $this->toJSON(array('pdf' => true), true);
    }
}
