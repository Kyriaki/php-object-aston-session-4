#!/usr/bin/php
 
<?php
 
 
 
/***************************************************************************************************\
 
            Name : SAMUS
            Attributes : uwu_file
            Methods : o3o_getFile, o3o_setFile, o3o_readFile, o3o_writeInFile              
            Functionality : Class that acts as a file manager. Reading and writing in file
 
                                                :D
 
\***************************************************************************************************/
 
//HERE COMES A NEW CHALLENGER n_n
class SAMUS{
 
    private $uwu_file;
 
    public function __construct(){
        $this->uwu_file = "";
    }
 
    public function o3o_getFile(){
        return $this->uwu_file;
    }
 
    public function o3o_setFile($file){
        $this->uwu_file = $file;
    }
 
    public function o3o_readFile(){
        readfile($this->uwu_file);
    }
 
    public function o3o_writeInFile($key, $value){
 
        $link = file($this->uwu_file);
        $toonlink = 0;
        foreach ($link as $lucario) {
            if (strpos($lucario, $key) !== false) {
                unset($link[$toonlink]);
            }
            $toonlink++;
        }
       
        $roy = fopen($this->uwu_file, 'w+');
        $ike = $key."=".$value."\n";
        fwrite($roy, implode("",$link));
        fwrite($roy, $ike);
        fclose($roy);
    }
 
    public function o3o_deleteWithKey($key){
        $marth = $key."=";
        $wolf = file($this->uwu_file);
        $pit = 0;
        foreach ($wolf as $wario) {
            if (strpos($wario, $marth) !== false) {
                $wolf[$pit] = $key."\n";
            }
            $pit++;
        }
 
        $ness = fopen($this->uwu_file, "w+");
        fwrite($ness, implode("", $wolf));
        fclose($ness);
    }
 
    public function o3o_deleteWithKeyAndValue($key, $value){
        $corrin = $key."=".$value."\n";
        $robin = file($this->uwu_file);
        $fox = 0;
        foreach ($robin as $mario) {
            if ($mario == $corrin) {
                unset($robin[$fox]);
            }
            $fox++;
        }
 
        $falco = fopen($this->uwu_file, "w+");
        fwrite($falco, implode("", $robin));
        fclose($falco);
    }
 
    public function o3o_searchInFile($expr){
        $zelda = file($this->uwu_file);
        $sheik = 0;
        foreach ($zelda as $diddykong) {
            if (strpos(explode("=", $diddykong)[0], $expr) === false) {
                unset($zelda[$sheik]);
            }
            $sheik++;
        }
 
        $sheik = 0;
        $ganondorf = array();
        foreach ($zelda as $donkeykong) {
            $ganondorf[$sheik] = explode('=', $donkeykong)[1];
            $sheik++;  
        }
 
        return implode("", $ganondorf);
    }
 
    public function o3o_clear(){
        $lucas = fopen($this->uwu_file, "w");
        fclose($lucas);
    }
 
    public function __destruct(){
    }
   
}
 
/*******************************************************************************************************************************
 
 *  Class name: KIRBY
             *  Inheritance: X
             *  Attributes: uwu_key, uwu_value, uwu_samus
             *  Methods: getKey_topkek, setKey_topkek, getValue_topkek, setValue_topkek, o3o_put, o3o_del, o3o_select, o3o_flush
             *  Functionality: Class that handles the writing and selecting methods for the sh.db file
             *  Visibility: X
                                   
                                                        :)
 
*******************************************************************************************************************************/
 
 
// HERE COMES A NEW CHALLENGER :3
class KIRBY {
 
    private $uwu_key;
    private $uwu_value;
    private $uwu_samus;
    private $uwu_filename;
 
    public function __construct(){
        $this->uwu_filename = "sh.db";
        $this->uwu_samus = new SAMUS();
        $this->uwu_samus->o3o_setFile($this->uwu_filename);
 
    }
 
    public function setFilename_topkek($filename){
        $this->uwu_filename = $filename;
        $this->uwu_samus->o3o_setFile($filename);
    }
 
    protected function getKey_topkek(){
        return $this->uwu_key;
    }
 
    protected function setKey_topkek($key){
        $this->uwu_key = $key;
    }
 
    protected function getValue_topkek(){
        return $this->uwu_value;
    }
 
    protected function setValue_topkek($value){
        $this->uwu_value = $value;
    }
 
 
 
    public function o3o_put($key, $value){
        if ($this->uwu_samus->o3o_getFile() == "sh.db"){
            $this->uwu_samus->o3o_writeInFile($key, $value);
        }
        else if (file_exists("sh.db")){
            $this->uwu_samus->o3o_setFile("sh.db");
            $this->uwu_samus->o3o_writeInFile($key, $value);
        }
        else {
            $olimar = fopen("sh.db", "a+");
            $this->uwu_samus->o3o_setFile("sh.db");
            $this->uwu_samus->o3o_writeInFile($key, $value);
            fclose($olimar);
        }
    }
 
    public function o3o_del(){
        if (func_num_args() == 1){
            $pikachu = func_get_arg(0);
            if(func_num_args() == 2){
                echo '2 args';
                $mewtwo = func_get_arg(1); 
                $this->uwu_samus->o3o_deleteWithKeyAndValue($pikachu, $mewtwo);
            } else {
                echo '1 arg';
                $this->uwu_samus->o3o_deleteWithKey($pikachu);
            }
        }
       
 
    }
 
    public function o3o_select(){
 
        if(func_get_arg(0) != false){
            $jigglypuff = func_get_arg(0);
            echo $this->uwu_samus->o3o_searchInFile($jigglypuff);
        }
        else {
            $this->uwu_samus->o3o_readFile();      
        }
    }
 
    public function o3o_flush(){
        $this->uwu_samus->o3o_clear();
    }
 
    public function __destruct(){
    }
 
 
 
}
 
$kirby = new KIRBY();
 
if ($argc > 1){
    $littleMac = $argv[1];
    if ($argc > 2){
        $bowser = array();
        if ($argc == 3){
            $bowser[0] = $argv[2];
        }
        if ($argc == 4){
            if (strpos($argv[2], "$") !== false && strpos($argv[3], "$") !== false) return 1;
            if (strpos($argv[2], "$") === false && strpos($argv[3], "$") === false){
                echo 'les 2 sans rien';
                $bowser[0] = $argv[2];
                $bowser[1] = $argv[3];
            }
            else if (strpos($argv[2], "$") !== false){
                echo '1$';
                $bowser[0] = $argv[2];
                $bowser[1] = $argv[3];
            }
            else {
                echo "l'autre 1$";
                $bowser[0] = $argv[3];
                $bowser[1] = $argv[2];
            }
        }
 
    }
}
if ($littleMac == 'put' || $littleMac == 'select' || $littleMac == 'del'){
 
 
    if ($littleMac == 'put' && $argc == 4){
        $kirby->o3o_put($bowser[0], $bowser[1]);
        return 0;
    }
 
    if ($littleMac == 'select' && $argc == 2){
        $kirby->o3o_select();
        return 0;
    }
    else if ($littleMac == 'select' && $argc == 3){
        $kirby->o3o_select($bowser[0]);
        return 0;
    }
 
    if ($littleMac == 'del' && $argc == 3){
        $kirby->o3o_del($bowser[0]);
        return 0;
    }
    else if ($littleMac == 'del' && $argc == 4){
        $kirby->o3o_del($bowser[0], $bowser[1]);
        return 0;
    }
}
else {
    echo 'Failure!';
    return 1;
}
 
?>