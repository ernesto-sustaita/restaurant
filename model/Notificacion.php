<?php
namespace model;

use database\DB;

/**
 *
 * @author ernesto
 *        
 */
class Notificacion
{
    private $db;
    private $id;
    private $tipo;
    private $fechaHora;
    private $idForanea;
    private $mensaje;
    private $vista;
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
    public function getTipo() : int
    {
        return $this->tipo;
    }

    /**
     * @return int
     */
    public function getFechaHora() : int
    {
        return $this->fechaHora;
    }

    /**
     * @return int
     */
    public function getIdForanea()
    {
        return $this->idForanea;
    }

    /**
     * @return string
     */
    public function getMensaje() : string
    {
        return $this->mensaje;
    }

    /**
     * @return bool
     */
    public function getVista() : bool
    {
        return $this->vista;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $this->db->escape($id);
    }

    /**
     * @param int $tipo
     */
    public function setTipo(int $tipo)
    {
        $this->tipo = $this->db->escape($tipo);
    }

    /**
     * @param int $fechaHora
     */
    public function setFechaHora(int $fechaHora)
    {
        $this->fechaHora = $this->db->escape($fechaHora);
    }

    /**
     * @param int $idForanea
     */
    public function setIdForanea(int $idForanea)
    {
        $this->idForanea = $this->db->escape($idForanea);
    }

    /**
     * @param string $mensaje
     */
    public function setMensaje(string $mensaje)
    {
        $this->mensaje = $this->db->escape($mensaje);
    }

    /**
     * @param bool $vista
     */
    public function setVista(bool $vista)
    {
        $this->vista = $this->db->escape($vista);
    }

    public function __construct(){
        $this->db = DB::getInstance();
    }
    
    public function crear() {
        $sql = "INSERT INTO notificacion (tipo, fecha_hora, id_foranea, mensaje, vista)
                        VALUES ($this->tipo, " . time() . ", $this->idForanea, '$this->mensaje', 0)";
        
        return $this->db->query($sql);
    }
    
    public function consultarExiseNotificacionPreviaHoy(){
        $sql = "SELECT id FROM notificacion
                    WHERE FROM_UNIXTIME(fecha_hora, '%Y-%m-%d') = CURDATE() AND id_foranea = $this->idForanea AND tipo = $this->tipo";
        
        return $this->db->query($sql);
    }
    
    public function consultarCantidadNotificacionesExistenciaNoVistas(){
        $sql = "SELECT COUNT(id) AS cantidad FROM notificacion
                    WHERE FROM_UNIXTIME(fecha_hora, '%Y-%m-%d') = CURDATE() AND tipo = 1 AND vista = 0";
        
        return $this->db->query($sql);
    }
    
    public function consultarCantidadNotificacionesComandaNoVistas(){
        $sql = "SELECT COUNT(id) AS cantidad FROM notificacion
                    WHERE FROM_UNIXTIME(fecha_hora, '%Y-%m-%d') = CURDATE() AND tipo = 2 AND vista = 0";
        
        return $this->db->query($sql);
    }
    
    public function consultarNotificacionesExistencias(){
        $sql = "SELECT id, fecha_hora, mensaje, vista FROM notificacion
                    WHERE tipo = 1 AND FROM_UNIXTIME(fecha_hora, '%Y-%m-%d') = CURDATE()
                    ORDER BY fecha_hora DESC";
        
        return $this->db->query($sql);
    }
    
    public function consultarNotificacionesComandas(){
        $sql = "SELECT id, fecha_hora, mensaje, vista FROM notificacion
                    WHERE tipo = 2 AND FROM_UNIXTIME(fecha_hora, '%Y-%m-%d') = CURDATE()
                    ORDER BY fecha_hora DESC";
        
        return $this->db->query($sql);
    }
    
    public function marcarComoLeida(){
        $sql = "UPDATE notificacion SET vista = 1 WHERE id = $this->id";
        
        return $this->db->query($sql);
    }
}

