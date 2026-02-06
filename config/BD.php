<?php
require_once __DIR__ . '/connect_db.php';
class bd{
    public function __construct(){
$this->db=Conectar::conexion();
 }
 /* Funcion para el ingreso de usuario y contrasena */
 public function validacion ($sql){
    $resultado = $this->db->query($sql);
    $res=0;
    if($resultado === false){
        echo "error de consulta" . $this->db->error;
        $res = 0;
    }elseif($resultado->num_rows > 0){
        $res++;
    }else{
       echo "Datos erroneos, vuelva a intentar";
            $res = 0; 
    }
    return $res;
 }

 public function combo($sql, $id, $des, $No){
    $resultado = $this->db->query($sql);
    if($resultado && $resultado->num_rows > 0){
        while($row=$resultado->fetch_assoc()){
            if($row[$id]!= $No){
                echo '<option value="'.$row[$id].'">'.$row[$des].'</option>';
            }
        }
    }
 }

 public function abc($sql){
    if($this->db->query(trim($sql))==TRUE){
        return true;
    }else{
        echo "Error: ".$this->db->error;
        return false;
    }
 }

 public function ultimo_id() {
        return $this->db->insert_id;
    }

 public function extraerCampo($sql, $campo){
    $resultado = $this->db->query($sql);
    $res="";
    if($resultado && $resultado->num_rows > 0){
        while($row= $resultado->fetch_assoc()){
            $res=$row[$campo];
        }
    }else{
        $res="Error...";
    }
    return $res;
 }

 /** Devuelve array de filas (asociativo). Para listados y búsquedas. */
 public function getFilas($sql){
    $resultado = $this->db->query($sql);
    $filas = array();
    if($resultado && $resultado->num_rows > 0){
        while($row = $resultado->fetch_assoc()){
            $filas[] = $row;
        }
    }
    return $filas;
 }

}
?>