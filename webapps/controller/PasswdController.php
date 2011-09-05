<?php

class PasswdController extends DooController {

    public function change() {

        if (!$this->isAjax()) {
            $data['baseurl'] = Doo::conf()->APP_URL;
            $this->view()->render('changepwd', $data, true);
        }
    }

    public function lost() {

        if (!$this->isAjax()) {
            $data['baseurl'] = Doo::conf()->APP_URL;
            $this->view()->render('lostpwd', $data, true);
        }
    }
}
