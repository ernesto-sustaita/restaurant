<?php
namespace model;

use database\DB;

/**
 *
 * @author ernesto
 *        
 */
class Usuario
{
    private $db;
    private $id;
    private $nombre;
    private $contrasena;
    private $fechaRegistro;
    private $tipoUsuario;
    private $estatus;
    
    public function setId(int $_id){
        $this->id = $this->db->escape($_id);
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setNombre(string $_nombre){
        $this->nombre = $this->db->escape($_nombre);
    }
    
    public function getNombre(){
        return $this->nombre;
    }
    
    public function setContrasena(string $_contrasena){
        $this->contrasena = $this->db->escape($_contrasena);
    }
    
    public function getContrasena(){
        return $this->contrasena;
    }
    
    public function setFechaRegistro(string $_fechaRegistro){
        $this->fechaRegistro = $this->db->escape($_fechaRegistro);
    }
    
    public function getFechaRegistro(){
        return $this->fechaRegistro;
    }
    
    public function setTipoUsuario(int $_tipoUsuario){
        $this->tipoUsuario = $this->db->escape($_tipoUsuario);
    }
    
    public function getTipoUsuario(){
        return $this->tipoUsuario;
    }
    
    public function setEstatus(int $_estatus){
        $this->estatus = $this->db->escape($_estatus);
    }
    
    public function getEstatus(){
        return $this->estatus;
    }
    
    public function __construct(){
        $this->db = DB::getInstance();
    }
    
    public function consultarUsuarios(){
        $sql = "SELECT id, username, profile, reg_date, estatus FROM users";
        
        return $this->db->query($sql);
    }
    
    public function nuevoUsuario() {
        $sql = "INSERT INTO users (username, password, profile, reg_date, estatus)
                VALUES ('$this->nombre','" . sha1($this->contrasena) . "', $this->tipoUsuario, " . time() .", $this->estatus)";
        
        return $this->db->query($sql);
    }
    
    public function actualizarUsuario() {
        if($this->contrasena == ""){
            $sql = "UPDATE users SET username = '$this->nombre', profile = $this->tipoUsuario, estatus = $this->estatus
                WHERE id = $this->id";
        } else {
            $sql = "UPDATE users SET username = '$this->nombre', password = '" . sha1($this->contrasena) . "', profile = $this->tipoUsuario, estatus = $this->estatus
                WHERE id = $this->id";
        }
        
        return $this->db->query($sql);
    }
    
    public function eliminarUsuario() : int {
        
        $sql = "SELECT COUNT(id) AS CantidadEnComandas FROM comanda WHERE usuarix_id = $this->id";
        
        $resultadoCantidadComandas = $this->db->query($sql);
        
        $cantidadEnComandas = 0;
        if($resultadoCantidadComandas->num_rows > 0) {
            $cantidadEnComandas = $resultadoCantidadComandas->fetch_object()->CantidadEnComandas;
        }
        
        $sql = "SELECT COUNT(id) AS CantidadEnCortes FROM corte WHERE usuario_id = $this->id";
        
        $resultadoCantidadCortes = $this->db->query($sql);
        
        $cantidadEnCortes = 0;
        if($resultadoCantidadCortes->num_rows > 0) {
            $cantidadEnCortes = $resultadoCantidadCortes->fetch_object()->CantidadEnCortes;
        }
        
        if($cantidadEnComandas > 0 || $cantidadEnCortes > 0){
            // Marcamos el producto como inactivo
            $sql = "UPDATE users SET estatus = 0 WHERE id = $this->id";
            
            if($this->db->query($sql)) {
                return 2;
            }
            
            return 0;
        } else {
            
            if(!$this->db->query("DELETE FROM users WHERE id = $this->id")){
                return 0;
            }
            
            return 1;
        }
    }
    
    public function conexion() {
        $sql = "SELECT id, username, profile FROM users WHERE username = '$this->nombre' AND password = '" . sha1($this->contrasena) . "' AND estatus = 1";
        
        return $this->db->query($sql);
    }
}

