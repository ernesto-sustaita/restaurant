<?php
namespace model;

use database\DB;

/**
 *
 * @author ernesto
 *        
 */
class Corte
{
    private $db;
    private $id;
    private $usuarioId;
    private $fechaHora;
    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUsuarioId() : int
    {
        return $this->usuarioId;
    }

    /**
     * @return int Fecha y hora en formato Unix Timestamp
     */
    public function getFechaHora() : int
    {
        return $this->fechaHora;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param int $usuarioId
     */
    public function setUsuarioId(int $usuarioId)
    {
        $this->usuarioId = $usuarioId;
    }

    /**
     * @param int $fechaHora
     */
    public function setFechaHora(int $fechaHora)
    {
        $this->fechaHora = $fechaHora;
    }

    public function __construct(){
        $this->db = DB::getInstance();
    }
    
    public function crear(array $detallesCorte){
        $this->db->query("START TRANSACTION");
        
        $fechaHora = time();
        
        $sql = "INSERT INTO corte (fecha_hora, usuario_id)
                VALUES (?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii",$fechaHora,$this->usuarioId);
        
        $exito = true;
        
        if($stmt->execute()) {
            $idCorte = $this->db->getLastInsertId();
            
            foreach ($detallesCorte as $detalle){
                $sql = "INSERT INTO detalle_corte (tipo, cantidad, corte_id)
                VALUES (?, ?, ?)";
                
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("idi",$detalle['tipo'],$detalle['cantidad'], $idCorte);
                
                if(!$stmt->execute()){
                    $exito = false;
                }
            }
        } else {
            $this->db->query("ROLLBACK;");
            $stmt->close();
            return false;
        }
        
        $stmt->close();
        
        if($exito){
            $this->db->query("COMMIT;");
            return true;
        } else {
            $this->db->query("ROLLBACK;");
            return false;
        }
    }
    
    public function obtenerCortePorFechaActual(){
        $sql = "SELECT id, fecha_hora, usuario_id 
                    FROM corte WHERE FROM_UNIXTIME(fecha_hora, '%Y-%m-%d') = CURDATE()";
        
        return $this->db->query($sql);
    }
    
    public function obtenerDetallesCorte() {
        $sql = "SELECT id, tipo, cantidad 
                    FROM detalle_corte
                    WHERE corte_id = $this->id";
        
        return $this->db->query($sql);
    }
}

