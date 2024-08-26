<?php

namespace src\Services;

trait Reponse {

    public function render(string $view, array $data = [
        'section' => '',
        'action' => ''
        ]) {

            if(!empty($data)) {
                foreach ($data as $key => $value) {
                    ${$key} = $value;
                }
            }
            if(!isset($section)) {
                $section = '';
            }
            if(!isset($action)) {
                $action = '';
            }
            include_once __DIR__.'/../Views/'.$view.'.php';
    }

    public function sendJson(array|null $data = null, int $code = 200):void {
        ob_clean();
        header("Content-Type: application/json");
        http_response_code($code);
        if($data){
            echo json_encode($data);
        }
    }
}