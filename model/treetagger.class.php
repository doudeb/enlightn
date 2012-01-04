<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class treeTagger {

    private $default_langage;
    private $dictionary;
    private $text;
    private $tagger_patern;
    private $tagger_result;
    private $tagger_path;
    private $sorted_tagger_result   = array();


    public function __construct($default_langage = 'english', $text) {
        $this->default_langage  = $default_langage;
        $this->text             = $text;
        defined('PATH_TO_TREETAGGER')?$this->tagger_path = PATH_TO_TREETAGGER:$this->tagger_path = '/usr/local/bin/treetagger/';
    }


    private function format_tagger_result () {
        foreach($this->tagger_result as $key=>$line) {
            $this->explode_result_line($line, $key);
        }
    }

    private function explode_result_line ($result,$key) {
        $data   = explode ("\t",$result);
        if (preg_match($this->tagger_patern, $data[1])) {

                $this->tagger_result[$key]    = $data;
        } else {
                unset($this->tagger_result[$key]);
        }
    }

    private function sort_tagger_result () {
        if (!is_array($this->tagger_result)) {
                return false;
        }
        foreach($this->tagger_result as $key=>$line) {
                if ($line[2] === '<unknown>') {
                        $tag    = $line[0];
                } else {
                        $tag    = $line[2];
                }
                if (isset( $this->sorted_tagger_result[$tag])) {
                        $this->sorted_tagger_result[$tag]    +=  1;
                } else {
                        $this->sorted_tagger_result[$tag]     =  1;
                }
        }
        asort($this->sorted_tagger_result);
        $this->sorted_tagger_result           = array_reverse($this->sorted_tagger_result);
    }

    public function tag_text () {
        $this->set_dictionary();
        $this->execute_tagger();
        $this->format_tagger_result();
        $this->sort_tagger_result();
        return $this->sorted_tagger_result;
    }

    private function execute_tagger () {
        ob_start();
        exec($this->tagger_path . $this->dictionary . ' ' . $this->text, $this->tagger_result);
        ob_end_clean();
    }

    private function set_dictionary() {
        switch ($this->default_langage) {
        case 'english' :
                $this->dictionary       = 'tree-tagger-english';
                $this->tagger_patern    = '/NN|NP/';
                break;
        case 'french' :
        default :
                $this->dictionary       = 'tree-tagger-french-utf8';
                $this->tagger_patern    = '/NOM|NAM/';
                break;
        }

    }

    public function __destruct() {
    }

}

?>
