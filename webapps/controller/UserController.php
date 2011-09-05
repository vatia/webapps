<?php

class UserController extends DooController {

    /**
     * Registro de nuevo usuario
     */
    public function register() {

        if ($this->isAjax()) {
            // TODO: registrar usuario en base de datos
        } else {
            $this->view()->render('signup');
        }

    }

    /**
     * Correo de confirmacion
     */
    public function sendmail() {

    }

    /**
     * Link de confirmacion
     */
    public function confirm() {

    }

    /**
     * Genera clave
     */
    public function pin() {

    }

    /**
     *
     */
    public function delete() {

    }

    /**
     *
     */
    public function modify() {

    }

    /**
     *
     */
    public function changePin() {

    }

    /**
     *
     */
    public function lostPin() {

    }
}
