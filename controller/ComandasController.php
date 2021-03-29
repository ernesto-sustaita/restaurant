<?php
namespace controller;

use model\Comanda;

/**
 *
 * @author ernesto
 *        
 */
class ComandasController
{
    public static function crear(int $idUsuarix){
        $comanda = new Comanda();
        
        $comanda->setUsuarixId($idUsuarix);
        
        return $comanda->crear();
    }
    
    public static function obtenerPorId(int $id){
        $comanda = new Comanda();
        
        $comanda->setId($id);
        
        return $comanda->obtenerPorId();
    }
    
    public static function incluirCliente(int $id, int $idCliente){
        $comanda = new Comanda();
        
        $comanda->setId($id);
        $comanda->setClienteId($idCliente);
        
        return $comanda->incluirCliente();
    }
    
    public static function agregarTipo(int $id, int $tipo){
        $comanda = new Comanda();
        
        $comanda->setId($id);
        $comanda->setTipo($tipo);
        
        return $comanda->agregarTipo();
    }
    
    public static function agregarProducto(int $idComanda, int $idProducto){
        $comanda = new Comanda();
        
        return $comanda->agregarProducto($idComanda, $idProducto);
    }
    
    public static function actualizarCantidadProducto(int $idComanda, int $idProducto, int $cantidad) {
        $comanda = new Comanda();
        
        return  $comanda->actualizarCantidadProducto($idComanda, $idProducto, $cantidad);
    }
    
    public static function eliminarProductoComanda(int $idComanda, int $idProducto){
        $comanda = new Comanda();
        
        return  $comanda->eliminarProductoComanda($idComanda, $idProducto);
    }
    
    public static function obtenerComandasPendientes(){
        $comanda = new Comanda();
        
        return $comanda->obtenerComandasPendientes();
    }
    
    public static function obtenerComandasRecientes(int $pagina = 0) {
        $comanda = new Comanda();
        
        return $comanda->obtenerComandasRecientes($pagina);
    }
    
    public static function obtenerCantidadComandasRecientes() {
        $comanda = new Comanda();
        
        return $comanda->obtenerCantidadComandasRecientes();
    }
    
    public static function obtenerDetalleComanda($id){
        $comanda = new Comanda();
        
        $comanda->setId($id);
        
        return $comanda->obtenerDetalleComanda();
    }
    
    public static function marcarDetalleComandaPreparado($idDetalleComanda){
        $comanda = new Comanda();
        
        return $comanda->marcarDetalleComandaPreparado($idDetalleComanda);
    }
    
    public static function obtenerCantidadDetallesComandaPendientes($idComanda){
        $comanda = new Comanda();
        
        $comanda->setId($idComanda);
        
        return $comanda->obtenerCantidadDetallesComandaPendientes();
    }
    
    public static function marcarComandaPreparada($idComanda){
        $comanda = new Comanda();
        
        $comanda->setId($idComanda);
        
        return $comanda->marcarComandaPreparada($idComanda);
    }
    
    public static function marcarTodosDetallesComandaPreparados($id){
        $comanda = new Comanda();
        
        $comanda->setId($id);
        
        return $comanda->marcarTodosDetallesComandaPreparados();
    }
    
    public static function actualizarCostoEnvio(int $idComanda, float $costoEnvio){
        $comanda = new Comanda();
        
        $comanda->setId($idComanda);
        $comanda->setCostoEnvio($costoEnvio);
        
        return $comanda->actualizarCostoEnvio();
    }
    
    public static function agregarNota(int $idComanda, string $nota){
        $comanda = new Comanda();
        
        $comanda->setId($idComanda);
        $comanda->setNota($nota);
        
        return $comanda->agregarNota();
    }
    
    public static function cancelarComanda($id){
        $comanda = new Comanda();
        
        $comanda->setId($id);
        
        return $comanda->cancelarComanda();
    }
    
    public static function pagar(int $idComanda, int $tipoPago, float $cantidadRecibida){
        $comanda = new Comanda();
        
        $comanda->setId($idComanda);
        $comanda->setTipoPago($tipoPago);
        $comanda->setcantidadRecibida($cantidadRecibida);
        
        return $comanda->pagar();
    }
    
    public static function actualizarInventario(int $idComanda) : bool {
        $comanda = new Comanda();
        
        $comanda->setId($idComanda);
        
        return $comanda->actualizarInventario();
    }
    
    public static function obtenerComandasCorte(){
        $comanda = new Comanda();
        
        return $comanda->obtenerComandasCorte();
    }
    
    public static function obtenerDetallesComandaCorte(int $idComanda){
        $comanda = new Comanda();
        
        $comanda->setId($idComanda);
        
        return $comanda->obtenerDetallesComandaCorte();
    }
}

