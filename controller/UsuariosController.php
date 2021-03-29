<?php
namespace controller;

use model\Usuario;

/**
 *
 * @author ernesto
 *        
 */
class UsuariosController
{
    public static function consultarUsuarios(){
        $usuario = new Usuario();
        
        return $usuario->consultarUsuarios();
    }
    
    public static function nuevoUsuario(string $_nombre, string $_contrasena, int $_tipoUsuario, int $_estatus) {
        $usuario = new Usuario();
        
        $usuario->setNombre($_nombre);
        $usuario->setContrasena($_contrasena);
        $usuario->setTipoUsuario($_tipoUsuario);
        $usuario->setEstatus($_estatus);
        
        return $usuario->nuevoUsuario();
    }
    
    public static function actualizarUsuario(int $_id, string $_nombre, string $_contrasena, int $_tipoUsuario, int $_estatus) {
        $usuario = new Usuario();
        
        $usuario->setId($_id);
        $usuario->setNombre($_nombre);
        $usuario->setContrasena($_contrasena);
        $usuario->setTipoUsuario($_tipoUsuario);
        $usuario->setEstatus($_estatus);
        
        return $usuario->actualizarUsuario();
    }
    
    public static function eliminarUsuario($_id){
        $usuario = new Usuario();
        
        $usuario->setId($_id);
        
        return $usuario->eliminarUsuario();
    }
    
    public static function conexion(string $_nombre, string $_contrasena){
        $usuario = new Usuario();
        
        $usuario->setNombre($_nombre);
        $usuario->setContrasena($_contrasena);
        
        return $usuario->conexion();
    }
}

