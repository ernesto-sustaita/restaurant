<?php
namespace model;

use database\DB;

/**
 *
 * @author ernesto
 *        
 */
class Promocion
{
    private $db;
    private $id;
    private $nombre;
    private $tipo;
    private $cantidad;
    private $fechaInicio;
    private $fechaFin;
    private $idsProducto;
    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNombre() : string
    {
        return $this->nombre;
    }

    /**
     * @return int
     */
    public function getTipo() : int
    {
        return $this->tipo;
    }

    /**
     * @return float
     */
    public function getCantidad() : float
    {
        return $this->cantidad;
    }

    /**
     * @return int En formato Unix timestamp
     */
    public function getFechaInicio() : int
    {
        return $this->fechaInicio;
    }

    /**
     * @return int En formato Unix timestamp
     */
    public function getFechaFin() : int
    {
        return $this->fechaFin;
    }

    /**
     * @return array
     */
    public function getIdsProducto() : array
    {
        return $this->idsProducto;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $this->db->escape($id);
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre)
    {
        $this->nombre = $this->db->escape($nombre);
    }

    /**
     * @param int $tipo
     */
    public function setTipo(int $tipo)
    {
        $this->tipo = $this->db->escape($tipo);
    }

    /**
     * @param float $cantidad
     */
    public function setCantidad(float $cantidad)
    {
        $this->cantidad = $this->db->escape($cantidad);
    }

    /**
     * @param int $fechaInicio
     */
    public function setFechaInicio(int $fechaInicio)
    {
        $this->fechaInicio = $this->db->escape($fechaInicio);
    }

    /**
     * @param int $fechaFin
     */
    public function setFechaFin(int $fechaFin)
    {
        $this->fechaFin = $this->db->escape($fechaFin);
    }

    /**
     * @param array $idsProducto
     */
    public function setIdsProducto(array $idsProducto)
    {
        foreach ($idsProducto as $clave => $valor){
            $idsProducto[$clave] = $this->db->escape($valor);
        }
        $this->idsProducto = $idsProducto;
    }

    public function __construct(){
        $this->db = DB::getInstance();
    }
    
    public function consultar(){
        
    }
    
    public function crear(){
        $this->db->query("START TRANSACTION;");
        
        $sql = "INSERT INTO producto (nombre, precio, estatus)
                VALUES (?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sdi",$this->nombre,$this->precio,$estatus);
        
        if($stmt->execute()) {
            $id_producto = $this->db->getLastInsertId();
            
            foreach ($this->datosInsumos as $insumo){
                $sql = "INSERT INTO producto_insumo (producto_id, insumo_id, cantidad)
                            VALUES (?, ?, ?)";
                
                $stmt = $this->db->prepare($sql);
                
                $stmt->bind_param("iii", $id_producto, $insumo['idInsumo'], $insumo['cantidad']);
                
                if(!$stmt->execute()){
                    $this->db->query("ROLLBACK;");
                    $stmt->close();
                    return false;
                }
            }
            
            foreach ($this->datosImpuestos as $impuesto){
                $sql = "INSERT INTO producto_impuesto (producto_id, impuesto_id)
                            VALUES (?, ?)";
                
                $stmt = $this->db->prepare($sql);
                
                $stmt->bind_param("ii", $id_producto, $impuesto['idImpuesto']);
                
                if(!$stmt->execute()){
                    $this->db->query("ROLLBACK;");
                    $stmt->close();
                    return false;
                }
            }
            
            foreach ($this->datosCategorias as $categoria){
                $sql = "INSERT INTO producto_categoria (producto_id, categoria_id)
                            VALUES (?, ?)";
                
                $stmt = $this->db->prepare($sql);
                
                $stmt->bind_param("ii", $id_producto, $categoria['idCategoria']);
                
                if(!$stmt->execute()){
                    $this->db->query("ROLLBACK;");
                    $stmt->close();
                    return false;
                }
            }
        } else {
            $this->db->query("ROLLBACK;");
            $stmt->close();
            return false;
        }
        
        $stmt->close();
        
        $this->db->query("COMMIT;");
        return true;
    }
}

