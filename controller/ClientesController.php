<?php
namespace controller;

use model\Cliente;

/**
 *
 * @author ernesto
 *        
 */
class ClientesController
{
    public static function consultar(){
        $cliente = new Cliente();
        
        return $cliente->consultar();
    }
    
    public static function consultarActivxs(){
        $cliente = new Cliente();
        
        return $cliente->consultarActivxs();
    }
    
    public static function consultarPorId(int $id){
        $cliente = new Cliente();
        
        return $cliente->consultarPorId($id);
    }
    
    public static function consultarDatosContacto(int $idCliente){
        $cliente = new Cliente();
        
        return $cliente->consultarDatosContacto($idCliente);
    }
    
    public static function consultarPaginado($pagina, $tamano_pagina){
        $cliente = new Cliente();
        
        return $cliente->consultarPaginado($pagina,$tamano_pagina);
    }
    
    public static function cantidadClientes(){
        $cliente = new Cliente();
        
        return $cliente->cantidadClientes();
    }
    
    public static function buscar($busqueda){
        $cliente = new Cliente();
        
        return $cliente->buscar($busqueda);
    }
    
    public static function buscarActivxs($busqueda){
        $cliente = new Cliente();
        
        return $cliente->buscarActivxs($busqueda);
    }
    
    public static function crear(string $nombre, string $apellidos, string $calle, string $numero_exterior,
        string $numero_interior, string $colonia, string $ciudad, string $estado,
        string $codigo_postal, string $url_mapa, string $rfc, int $estatus, array $datos_contacto) {
        $cliente = new Cliente();
        
        $cliente->setNombre($nombre);
        $cliente->setApellidos($apellidos);
        $cliente->setCalle($calle);
        $cliente->setNumeroExterior($numero_exterior);
        $cliente->setNumeroInterior($numero_interior);
        $cliente->setColonia($colonia);
        $cliente->setCiudad($ciudad);
        $cliente->setEstado($estado);
        $cliente->setCodigoPostal($codigo_postal);
        $cliente->setUrlMapa($url_mapa);
        $cliente->setRfc($rfc);
        $cliente->setEstatus($estatus);
        $cliente->setDatosContacto($datos_contacto);
        
        return $cliente->crear();
    }
    
    public static function actualizar(int $id, string $nombre, string $apellidos, string $calle, string $numero_exterior,
        string $numero_interior, string $colonia, string $ciudad, string $estado,
        string $codigo_postal, string $url_mapa, string $rfc, int $estatus, array $datos_contacto) {
        $cliente = new Cliente();
        
        $cliente->setId($id);
        $cliente->setNombre($nombre);
        $cliente->setApellidos($apellidos);
        $cliente->setCalle($calle);
        $cliente->setNumeroExterior($numero_exterior);
        $cliente->setNumeroInterior($numero_interior);
        $cliente->setColonia($colonia);
        $cliente->setCiudad($ciudad);
        $cliente->setEstado($estado);
        $cliente->setCodigoPostal($codigo_postal);
        $cliente->setUrlMapa($url_mapa);
        $cliente->setRfc($rfc);
        $cliente->setEstatus($estatus);
        $cliente->setDatosContacto($datos_contacto);
        
        return $cliente->actualizar();
    }
    
    public static function eliminar($id){
        $cliente = new Cliente();
        
        $cliente->setId($id);
        
        return $cliente->eliminar();
    }
}

