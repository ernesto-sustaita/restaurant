<?php
namespace model;

use database\DB;

/**
 *
 * @author ernesto
 *
 */
class Insumo
{
    private $db;
    private $id;
    private $nombre;
    private $existencia;
    private $alerta;
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
    
    public function setExistencia(int $_existencia){
        $this->existencia = $this->db->escape($_existencia);
    }
    
    public function getExistencia(){
        return $this->existencia;
    }
    
    public function setAlerta(int $_alerta){
        $this->alerta = $this->db->escape($_alerta);
    }
    
    public function getAlerta(){
        return $this->alerta;
    }
    
    public function setEstatus(int $_estatus){
        $this->estatus= $this->db->escape($_estatus);
    }
    
    public function getEstatus(){
        return $this->estatus;
    }
    
    public function __construct(){
        $this->db = DB::getInstance();
    }
    
    public function consultar(){
        $sql = "SELECT id, nombre, existencias, alerta, estatus FROM insumo";
        
        return $this->db->query($sql);
    }
    
    public function consultarActivos(){
        $sql = "SELECT id, nombre, existencias, alerta, estatus FROM insumo WHERE estatus = 1";
        
        return $this->db->query($sql);
    }
    
    public function crear() {
        $sql = "INSERT INTO insumo (nombre, existencias, alerta, estatus)
                VALUES ('$this->nombre', $this->existencia, $this->alerta, $this->estatus)";
        
        return $this->db->query($sql);
    }
    
    public function actualizar() {
        $sql = "UPDATE insumo SET nombre = '$this->nombre', existencias = $this->existencia, alerta = $this->alerta, estatus = $this->estatus
            WHERE id = $this->id";
        
        return $this->db->query($sql);
    }
    
    public function eliminar() : int {
        
        $sql = "SELECT COUNT(id) AS CantidadEnProductos FROM producto_insumo WHERE insumo_id = $this->id";
        
        $resultadoCantidadProductos = $this->db->query($sql);
        
        $cantidadEnProductos = 0;
        if($resultadoCantidadProductos->num_rows > 0) {
            $cantidadEnProductos = $resultadoCantidadProductos->fetch_object()->CantidadEnProductos;
        }
        
        if($cantidadEnProductos > 0 ){
            // Marcamos el producto como inactivo
            $sql = "UPDATE insumo SET estatus = 0 WHERE id = $this->id";
            
            if($this->db->query($sql)) {
                return 2;
            }
            
            return 0;
        } else {
            
            if(!$this->db->query("DELETE FROM insumo WHERE id = $this->id")){
                return 0;
            }
            
            return 1;
        }
    }
}

