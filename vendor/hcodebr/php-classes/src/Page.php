<?php

namespace Hcode;

use Rain\Tpl;

class Page {

    private $tpl;
    private $options = [];
    private $defaults = [
        "header" => true,
        "footer" => true,
        "data" => []
    ];

    public function __construct($option = array(), $tpl_dir = "/views/") {
//        $this->defaults['data']['sessions'] = $_SESSION;
        $this->options = array_merge($this->defaults, $option);

// config RainTpl
        $config = array(
            "tpl_dir" => $_SERVER['DOCUMENT_ROOT'] . $tpl_dir,
            "cache_dir" => $_SERVER['DOCUMENT_ROOT'] . "/views-cache/",
            "debug" => false // set to false to improve the speed
        );

        Tpl::configure($config);

        $this->tpl = new Tpl();

        $this->setData($this->options['data']);

        // Inclui o header
        if ($this->options['header'] === TRUE)
            $this->tpl->draw('header');
    }

    public function setTpl($name, $data = array(), $returnHTML = false) {
        $this->setData($data);
        return $this->tpl->draw($name, $returnHTML);
    }

    // Inclui o rodapé
    public function __destruct() {
        if ($this->options['footer'] === TRUE)
            $this->tpl->draw('footer');
    }

    private function setData($data = array()) {
        foreach ($data as $key => $value) {
            $this->tpl->assign($key, $value);
        }
    }

}
