<?php
namespace model;

use database\DB;

/**
 *
 * @author ernesto
 *
 */
class Impuesto
{
    private $db;
    private $id;
    private $nombre;
    private $porcentaje;
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
    
    public function setPorcentaje(float $_porcentaje){
        $this->porcentaje = $this->db->escape($_porcentaje);
    }
    
    public function getPorcentaje(){
        return $this->porcentaje;
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
        $sql = "SELECT id, nombre, porcentaje, estatus FROM impuesto";
        
        return $this->db->query($sql);
    }
    
    public function consultarActivos(){
        $sql = "SELECT id, nombre, porcentaje, estatus FROM impuesto WHERE estatus = 1";
        
        return $this->db->query($sql);
    }
    
    public function crear() {
        $sql = "INSERT INTO impuesto (nombre, porcentaje, estatus)
                VALUES ('$this->nombre', $this->porcentaje, $this->estatus)";
        
        return $this->db->query($sql);
    }
    
    public function actualizar() {
        $sql = "UPDATE impuesto SET nombre = '$this->nombre', porcentaje = $this->porcentaje, estatus = $this->estatus
            WHERE id = $this->id";
        
        return $this->db->query($sql);
    }
    
    public function eliminar() : int {
        
        $sql = "SELECT COUNT(id) AS CantidadEnProductos FROM producto_impuesto WHERE impuesto_id = $this->id";
        
        $resultadoCantidadProductos = $this->db->query($sql);
        
        $cantidadEnProductos = 0;
        if($resultadoCantidadProductos->num_rows > 0) {
            $cantidadEnProductos = $resultadoCantidadProductos->fetch_object()->CantidadEnProductos;
        }
        
        if($cantidadEnProductos > 0 ){
            // Marcamos el producto como inactivo
            $sql = "UPDATE impuesto SET estatus = 0 WHERE id = $this->id";
            
            if($this->db->query($sql)) {
                return 2;
            }
            
            return 0;
        } else {
            
            if(!$this->db->query("DELETE FROM impuesto WHERE id = $this->id")){
                return 0;
            }
            
            return 1;
        }
    }
}

