<?php
namespace model;

use database\DB;

/**
 *
 * @author ernesto
 *
 */
class Categoria
{
    private $db;
    private $id;
    private $nombre;
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
        $sql = "SELECT id, nombre, estatus FROM categoria";
        
        return $this->db->query($sql);
    }
    
    public function consultarActivas(){
        $sql = "SELECT id, nombre, estatus FROM categoria WHERE estatus = 1";
        
        return $this->db->query($sql);
    }
    
    public function crear() {
        $sql = "INSERT INTO categoria (nombre, estatus)
                VALUES ('$this->nombre',$this->estatus)";
        
        return $this->db->query($sql);
    }
    
    public function actualizar() {
        $sql = "UPDATE categoria SET nombre = '$this->nombre', estatus = $this->estatus
            WHERE id = $this->id";
        
        return $this->db->query($sql);
    }
    
    /**
     *
     * @return int 0 si falló la consulta, 1 si se eliminó el producto y los registros asociados (categorías, insumos, impuestos) y 2 si solo se desactivó porque ya está en comandas
     */
    public function eliminar() : int {
        $sql = "SELECT COUNT(id) AS CantidadEnProductos FROM producto_categoria WHERE categoria_id = $this->id";
        
        $resultadoCantidadProductos = $this->db->query($sql);
        
        $cantidadEnProductos = 0;
        if($resultadoCantidadProductos->num_rows > 0) {
            $cantidadEnProductos = $resultadoCantidadProductos->fetch_object()->CantidadEnProductos;
        }
        
        if($cantidadEnProductos > 0 ){
            // Marcamos el producto como inactivo
            $sql = "UPDATE categoria SET estatus = 0 WHERE id = $this->id";
            
            if($this->db->query($sql)) {
                return 2;
            }
            
            return 0;
        } else {
            
            if(!$this->db->query("DELETE FROM categoria WHERE id = $this->id")){
                return 0;
            }
            
            return 1;
        }
    }
}

