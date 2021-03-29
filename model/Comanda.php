<?php
namespace model;

require_once 'Producto.php';
require_once 'Notificacion.php';

use database\DB;

/**
 *
 * @author ernesto
 *        
 */
class Comanda
{
    private $db;
    private $id;
    private $cliente_id;
    private $mesa_id;
    private $meserx_id;
    private $tipo;
    private $fecha_hora;
    private $estatus;
    private $pagada;
    private $costo_envio;
    private $tipo_pago;
    private $nota;
    private $cantidad_recibida;
    private $usuarix_id;
    
    /**
     * @return mixed
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * @return bool
     */
    public function getPagada() : bool
    {
        return $this->pagada;
    }

    /**
     * @return mixed
     */
    public function getCostoEnvio()
    {
        return $this->costo_envio;
    }

    /**
     * @return mixed
     */
    public function getTipoPago()
    {
        return $this->tipo_pago;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getClienteId()
    {
        return $this->cliente_id;
    }

    /**
     * @return mixed
     */
    public function getMesaId()
    {
        return $this->mesa_id;
    }

    /**
     * @return mixed
     */
    public function getMeserxId()
    {
        return $this->meserx_id;
    }
    
    /**
     * @return int
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @return mixed
     */
    public function getFechaHora()
    {
        return $this->fecha_hora;
    }
    
    /**
     * @return string
     */
    public function getNota() : string
    {
        return $this->nota;
    }
    
    /**
     * @return float
     */
    public function getCantidadRecibida() : float
    {
        return $this->cantidad_recibida;
    }
    
    /**
     * @return int
     */
    public function getUsuarixId() : int
    {
        return $this->usuarix_id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $this->db->escape($id);
    }

    /**
     * @param int $cliente_id
     */
    public function setClienteId(int $cliente_id)
    {
        $this->cliente_id = $this->db->escape($cliente_id);
    }

    /**
     * @param int $mesa_id
     */
    public function setMesaId(int $mesa_id)
    {
        $this->mesa_id = $this->db->escape($mesa_id);
    }

    /**
     * @param int $meserx_id
     */
    public function setMeserxId(int $meserx_id)
    {
        $this->meserx_id = $this->db->escape($meserx_id);
    }
    
    /**
     * @param int $tipo
     */
    public function setTipo(int $tipo)
    {
        $this->tipo = $this->db->escape($tipo);
    }

    /**
     * @param mixed $fecha_hora
     */
    public function setFechaHora($fecha_hora)
    {
        $this->fecha_hora = $this->db->escape($fecha_hora);
    }
    
    /**
     * @param int $estatus
     */
    public function setEstatus(int $estatus)
    {
        $this->estatus = $this->db->escape($estatus);
    }
    
    /**
     * @param bool $pagada
     */
    public function setPagada(bool $pagada)
    {
        $this->pagada = $this->db->escape($pagada);
    }
    
    /**
     * @param float $costo_envio
     */
    public function setCostoEnvio(float $costo_envio)
    {
        $this->costo_envio = $this->db->escape($costo_envio);
    }
    
    /**
     * @param int $tipo_pago
     */
    public function setTipoPago(int $tipo_pago)
    {
        $this->tipo_pago = $this->db->escape($tipo_pago);
    }
    
    /**
     * @param string $nota
     */
    public function setNota(string $nota)
    {
        $this->nota = $this->db->escape($nota);
    }
    
    /**
     * @param float $cantidadRecibida
     */
    public function setCantidadRecibida(float $cantidadRecibida)
    {
        $this->cantidad_recibida = $this->db->escape($cantidadRecibida);
    }
    
    /**
     * @param int $idUsuarix
     */
    public function setUsuarixId(int $idUsuarix)
    {
        $this->usuarix_id = $this->db->escape($idUsuarix);
    }

    public function __construct(){
        $this->db = DB::getInstance();
    }
    
    public function crear(){
        $cliente_id = 0;
        $mesa_id = NULL;
        $meserx_id = NULL;
        $tipo = NULL;
        $fecha_hora = time();
        $estatus = 0;
        
        $sql = "INSERT INTO comanda (cliente_id, mesa_id, meserx_id, tipo, fecha_hora, estatus,usuarix_id) 
                    VALUES(?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiiiiii",$cliente_id,$mesa_id,$meserx_id,$tipo,$fecha_hora,$estatus,$this->usuarix_id);
        
        if($stmt->execute()){
            return $this->db->getLastInsertId();
        } else {
            return false;   
        }
    }
    
    public function obtenerPorId(){
        $sql = "SELECT comanda.id, cliente_id, cliente.nombre, cliente.apellidos,  mesa_id, meserx_id, tipo, fecha_hora, nota, costo_envio, pagada
                    FROM comanda 
                    LEFT JOIN cliente ON cliente.id = comanda.cliente_id 
                    WHERE comanda.id = $this->id";
        
        return $this->db->query($sql);
    }
    
    public function obtenerComandasRecientes(int $pagina = 0){
        $pagina = $this->db->escape($pagina);
        
        $pagina *= 10;
        
        $sql = "SELECT comanda.id, cliente_id, cliente.nombre, cliente.apellidos,  mesa_id, meserx_id, tipo, fecha_hora, pagada, costo_envio, nota
                    FROM comanda
                    LEFT JOIN cliente ON cliente.id = comanda.cliente_id
                    WHERE comanda.estatus != 2
                    ORDER BY fecha_hora DESC
                    LIMIT $pagina, 10";
        
        return $this->db->query($sql);
    }
    
    public function obtenerCantidadComandasRecientes(){
        $sql = "SELECT COUNT(id) AS ComandasRecientes FROM comanda WHERE estatus != 2";
        
        return  $this->db->query($sql);
    }
    
    public function incluirCliente(){
        
        $sql = "UPDATE comanda SET cliente_id = $this->cliente_id WHERE id = $this->id";
        
        return $this->db->query($sql);
    }
    
    public function agregarTipo(){
        
        if($this->tipo != 2) {
            $sql = "UPDATE comanda SET tipo = $this->tipo, costo_envio = 0 WHERE id = $this->id";
        } else {
            $sql = "UPDATE comanda SET tipo = $this->tipo WHERE id = $this->id";
        }
        
        
        return $this->db->query($sql);
    }
    
    public function agregarProducto(int $idComanda, int $idProducto) {
        // Para consultar el precio del producto al momento de hacer la órden
        $producto = new Producto();
        
        $producto->setId($idProducto);
        $resultadoProducto = $producto->consultarPorId();
        
        $datosProducto = $resultadoProducto->fetch_object();
        
        // Ahora consultaremos los impuestos para agregar lo que le corresponde, esto tiene el objetivo de que quede como histórico, por si alguna vez se modifican los impuestos o el precio del producto
        $resultadoImpuestos = $producto->consultarImpuestosPorProducto();
        
        $porcentajeTotalImpuesto = 0;
        if($resultadoImpuestos != NULL){
            while($impuesto = $resultadoImpuestos->fetch_object()){
                $porcentajeTotalImpuesto += $impuesto->porcentaje;
            }
        }
        
        $sql = "INSERT INTO comanda_producto (comanda_id, producto_id, cantidad, estatus, precio, impuesto)
                    VALUES(?, ?, ?, ?, ?, ?)";
        
        $cantidad = 1;
        $estatus = 1;
        $precioActualProducto = $datosProducto->precio;
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiiidd",$idComanda,$idProducto,$cantidad,$estatus,$precioActualProducto,$porcentajeTotalImpuesto);
        
        return $stmt->execute();
    }
    
    public function actualizarCantidadProducto(int $idComanda, int $idProducto, int $cantidad) {
        $sql = "UPDATE comanda_producto SET cantidad = ? WHERE comanda_id = ? AND producto_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iii",$cantidad,$idComanda,$idProducto);
        
        return $stmt->execute();
    }
    
    public function eliminarProductoComanda(int $idComanda, int $idProducto){
        $sql = "DELETE FROM comanda_producto WHERE comanda_id = ? AND producto_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii",$idComanda,$idProducto);
        
        return $stmt->execute();
    }
    
    public function obtenerComandasPendientes(){
        $sql = "SELECT comanda.id, cliente_id, cliente.nombre, cliente.apellidos,  mesa_id, meserx_id, tipo, fecha_hora
                    FROM comanda
                    LEFT JOIN cliente ON cliente.id = comanda.cliente_id
                    WHERE comanda.estatus = 0";
        
        return $this->db->query($sql);
    }
    
    public function obtenerDetalleComanda(){
        $sql = "SELECT comanda_producto.id, comanda_producto.comanda_id, comanda_producto.producto_id, producto.nombre, comanda_producto.precio,
                        comanda_producto.cantidad, comanda_producto.estatus, comanda_producto.impuesto
                    FROM comanda_producto
                    INNER JOIN producto ON comanda_producto.producto_id = producto.id
                    WHERE comanda_producto.comanda_id = $this->id";

        return $this->db->query($sql);
    }
    
    public function marcarDetalleComandaPreparado($idDetalleComanda){
        $idDetalleComanda = $this->db->escape($idDetalleComanda);
        
        $sql = "UPDATE comanda_producto SET estatus = 2 WHERE id = $idDetalleComanda";
        
        return $this->db->query($sql);
    }
    
    public function obtenerCantidadDetallesComandaPendientes(){
        $sql = "SELECT COUNT(id) AS DetallesPendientes FROM comanda_producto WHERE comanda_id = $this->id AND estatus = 1";
        
        return  $this->db->query($sql);
    }
    
    public function marcarComandaPreparada(){
        $sql = "UPDATE comanda SET estatus = 1 WHERE id = $this->id";
        
        if($this->db->query($sql)) {
            // Agregamos una notificación
            
            $notificacion = new Notificacion();
            $notificacion->setIdForanea($this->id);
            // 2 = comanda preparada
            $notificacion->setTipo(2);
            
            $resultadoExisteNotificacion = $notificacion->consultarExiseNotificacionPreviaHoy();
            
            // Si no trae filas de una notificacion que coincida, la creamos
            if($resultadoExisteNotificacion->num_rows < 1) {
                $notificacion->setMensaje("La comanda con el número '$this->id' está lista");
                
                $notificacion->crear();
            }
            
            return true;
        }
        
        return false;
    }
    
    public function marcarTodosDetallesComandaPreparados(){
        
        $sql = "UPDATE comanda_producto SET estatus = 2 WHERE comanda_id = $this->id";
        
        return $this->db->query($sql);
    }
    
    public function actualizarCostoEnvio(){
        $sql = "UPDATE comanda SET costo_envio = $this->costo_envio WHERE id = $this->id";
        
        return $this->db->query($sql);
    }
    
    public  function agregarNota(){
        $sql = "UPDATE comanda SET nota = '$this->nota' WHERE id = $this->id";
        
        return $this->db->query($sql);
    }
    
    public function cancelarComanda(){
        $sql = "UPDATE comanda SET estatus = 2 WHERE id = $this->id";
        
        return $this->db->query($sql);
    }
    
    public function pagar(){
        $sql = "UPDATE comanda SET pagada = 1, tipo_pago = $this->tipo_pago, cantidad_recibida = $this->cantidad_recibida
                    WHERE id = $this->id";

        return $this->db->query($sql);
    }
    
    /**
     * Actualiza el inventario y genera una notificación si la existencia está baja
     * @return bool
     */
    public function actualizarInventario() : bool {
        $sql = "SELECT producto_id, cantidad FROM comanda_producto WHERE comanda_id = $this->id";
        
        $resultadoProductosEnComanda = $this->db->query($sql);
        
        $exito = true;
        if($resultadoProductosEnComanda->num_rows > 0) {
            while($productoEnComanda = $resultadoProductosEnComanda->fetch_object()){
                $sql = "SELECT insumo_id, cantidad FROM producto_insumo WHERE producto_id = $productoEnComanda->producto_id";

                $resultadoProductoInsumo = $this->db->query($sql);
                
                if($resultadoProductoInsumo->num_rows >0){
                    while ($insumo = $resultadoProductoInsumo->fetch_object()) {
                        
                        $sql = "SELECT nombre, existencias, alerta FROM insumo WHERE id = $insumo->insumo_id";
                        
                        $datosInsumo = $this->db->query($sql)->fetch_object();
                        
                        $existenciasActualizadas = ($datosInsumo->existencias - ($insumo->cantidad * $productoEnComanda->cantidad));
                        
                        $sql = "UPDATE insumo SET existencias = $existenciasActualizadas WHERE id = $insumo->insumo_id";

                        if(!$this->db->query($sql)){
                            $exito = false;
                        } else {
                            if($existenciasActualizadas <= 5 && $datosInsumo->alerta) {
                                
                                $notificacion = new Notificacion();
                                
                                $notificacion->setIdForanea($insumo->insumo_id);
                                // 1 = insumo
                                $notificacion->setTipo(1);
                                
                                $resultadoExisteNotificacion = $notificacion->consultarExiseNotificacionPreviaHoy();
                                
                                // Si no trae filas de una notificacion que coincida, la creamos
                                if($resultadoExisteNotificacion->num_rows < 1) {
                                    $notificacion->setMensaje("Existencias bajas en el insumo '$datosInsumo->nombre'. Queda(n) $existenciasActualizadas en existencia");
                                    
                                    $notificacion->crear();
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return $exito;
    }
    
    public function obtenerComandasCorte(){
        $sql = "SELECT id, tipo, fecha_hora, costo_envio, tipo_pago FROM comanda 
                    WHERE FROM_UNIXTIME(fecha_hora, '%Y-%m-%d') = CURDATE() AND pagada = 1 AND estatus != 2
                    ORDER BY tipo_pago";
        
        return $this->db->query($sql);
    }
    
    public function obtenerDetallesComandaCorte(){
        $sql = "SELECT comanda_producto.id, producto.nombre, cantidad, comanda_producto.precio, impuesto 
                    FROM comanda_producto 
                    INNER JOIN producto ON producto.id = comanda_producto.producto_id
                    WHERE comanda_id = $this->id";
        
        return $this->db->query($sql);
    }
}

