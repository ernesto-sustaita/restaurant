<?php
namespace model;

use database\DB;

/**
 *
 * @author ernesto
 *        
 */
class Cliente
{
    private $db;
    private $id;
    private $nombre;
    private $apellidos;
    private $calle;
    private $numero_exterior;
    private $numero_interior;
    private $colonia;
    private $ciudad;
    private $estado;
    private $codigo_postal;
    private $url_mapa;
    private $rfc;
    private $estatus;
    private $datos_contacto;

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return string
     */
    public function getNumeroExterior()
    {
        return $this->numero_exterior;
    }

    /**
     * @return string
     */
    public function getNumeroInterior()
    {
        return $this->numero_interior;
    }

    /**
     * @return string
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @return string
     */
    public function getCodigoPostal()
    {
        return $this->codigo_postal;
    }

    /**
     * @return string
     */
    public function getUrlMapa()
    {
        return $this->url_mapa;
    }

    /**
     * @return string
     */
    public function getRfc()
    {
        return $this->rfc;
    }
    
    /**
     * @return int
     */
    public function getEstatus()
    {
        return $this->estatus;
    }
    
    /**
     * @return array
     */
    public function getDatosContacto()
    {
        return $this->datos_contacto;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos(string $apellidos)
    {
        $this->apellidos = $this->db->escape($apellidos);
    }

    /**
     * @param string $calle
     */
    public function setCalle(string $calle)
    {
        $this->calle = $this->db->escape($calle);
    }
    
    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre)
    {
        $this->nombre = $this->db->escape($nombre);
    }

    /**
     * @param string $numero_exterior
     */
    public function setNumeroExterior(string $numero_exterior)
    {
        $this->numero_exterior = $this->db->escape($numero_exterior);
    }

    /**
     * @param string $numero_interior
     */
    public function setNumeroInterior(string $numero_interior)
    {
        $this->numero_interior = $this->db->escape($numero_interior);
    }

    /**
     * @param string $colonia
     */
    public function setColonia(string $colonia)
    {
        $this->colonia = $this->db->escape($colonia);
    }

    /**
     * @param string $ciudad
     */
    public function setCiudad(string $ciudad)
    {
        $this->ciudad = $this->db->escape($ciudad);
    }

    /**
     * @param string $estado
     */
    public function setEstado(string $estado)
    {
        $this->estado = $this->db->escape($estado);
    }

    /**
     * @param string $codigo_postal
     */
    public function setCodigoPostal(string $codigo_postal)
    {
        $this->codigo_postal = $this->db->escape($codigo_postal);
    }
    
    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $this->db->escape($id);
    }

    /**
     * @param string $url_mapa
     */
    public function setUrlMapa(string $url_mapa)
    {
        $this->url_mapa = $this->db->escape($url_mapa);
    }

    /**
     * @param string $rfc
     */
    public function setRfc(string $rfc)
    {
        $this->rfc = $this->db->escape($rfc);
    }
    
    /**
     * @param int $rfc
     */
    public function setEstatus(int $estatus)
    {
        $this->estatus = $this->db->escape($estatus);
    }
    
    /**
     * @param array $datos_contacto
     */
    public function setDatosContacto(array $datos_contacto)
    {
        $this->datos_contacto = $datos_contacto;
    }
    
    public function __construct(){
        $this->db = DB::getInstance();
    }
    
    public function consultar(){
        $sql = "SELECT id, nombre, apellidos, calle, numero_exterior, numero_interior, colonia, ciudad,
                        estado, codigo_postal, url_mapa, rfc, estatus FROM cliente";
        
        return $this->db->query($sql);
    }
    
    public function consultarActivxs(){
        $sql = "SELECT id, nombre, apellidos, calle, numero_exterior, numero_interior, colonia, ciudad,
                        estado, codigo_postal, url_mapa, rfc, estatus FROM cliente WHERE estatus = 1";
        
        return $this->db->query($sql);
    }
    
    public function consultarPaginado($pagina, $tamano_pagina){
        $pagina = $this->db->escape($pagina);
        $tamano_pagina = $this->db->escape($tamano_pagina);
        
        $inicio = ($pagina -1) * $tamano_pagina;
        $sql = "SELECT id, nombre, apellidos, calle, numero_exterior, numero_interior, colonia, ciudad,
                        estado, codigo_postal, url_mapa, rfc, estatus FROM cliente LIMIT $inicio,$tamano_pagina";
        
        return $this->db->query($sql);
    }
    
    public function cantidadClientes(){
        $sql = "SELECT COUNT(id) AS cantidadClientes FROM cliente";
        
        return $this->db->query($sql);
    }
    
    public function consultarPorId(int $id){
        $id = $this->db->escape($id);
        
        $sql = "SELECT id, nombre, apellidos, calle, numero_exterior, numero_interior, colonia, ciudad,
                        estado, codigo_postal, url_mapa, rfc, estatus FROM cliente WHERE id = $id";
        
        return $this->db->query($sql);
    }
    
    public function consultarDatosContacto(int $idCliente){
        $id = $this->db->escape($idCliente);
        
        $sql = "SELECT id, tipo, valor FROM dato_contacto WHERE cliente_id = $id";
        
        return $this->db->query($sql);
    }
    
    public function buscar($busqueda){
        $busqueda = $this->db->escape($busqueda);
        
        $sql = "SELECT id, nombre, apellidos, calle, numero_exterior, numero_interior, colonia, ciudad,
                        estado, codigo_postal, url_mapa, rfc, estatus
                    FROM cliente 
                    WHERE nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%' OR id IN (SELECT cliente_id FROM dato_contacto WHERE valor LIKE '%$busqueda%')";
        
        return $this->db->query($sql);
    }
    
    public function buscarActivxs($busqueda){
        $busqueda = $this->db->escape($busqueda);
        
        $sql = "SELECT id, nombre, apellidos, calle, numero_exterior, numero_interior, colonia, ciudad,
                        estado, codigo_postal, url_mapa, rfc, estatus
                    FROM cliente
                    WHERE (nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%' OR id IN (SELECT cliente_id FROM dato_contacto WHERE valor LIKE '%$busqueda%')) AND estatus = 1";
        
        return $this->db->query($sql);
    }
    
    public function crear() {
        
        $this->db->query("START TRANSACTION;");
        
        $calle =  ($this->calle != "") ? $this->calle : NULL;
        $numeroExterior =  ($this->numero_exterior != "") ? $this->numero_exterior : NULL;
        $numeroInterior =  ($this->numero_interior != "") ? $this->numero_interior : NULL;
        $colonia =  ($this->colonia != "") ? $this->colonia : NULL;
        $ciudad = ($this->ciudad != "") ? $this->ciudad : NULL;
        $estado = ($this->estado != "") ? $this->estado : NULL;
        $codigoPostal = ($this->codigo_postal != "") ? $this->codigo_postal : NULL;
        $urlMapa = ($this->url_mapa != "") ? $this->url_mapa : NULL;
        $rfc = ($this->rfc != "") ? $this->rfc : NULL;
        $estatus = ($this->estatus != "") ? $this->estatus : NULL;
        
        $sql = "INSERT INTO cliente (nombre, apellidos, calle, numero_exterior, numero_interior, colonia, ciudad,
                        estado, codigo_postal, url_mapa, rfc, estatus)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssssssisssi",$this->nombre,$this->apellidos,$calle,$numeroExterior,$numeroInterior,
            $colonia,$ciudad,$estado,$codigoPostal,$urlMapa,$rfc,$estatus);
        
        if($stmt->execute()) {
            $id_cliente = $this->db->getLastInsertId();
            
            foreach ($this->datos_contacto as $dato){
                $sql = "INSERT INTO dato_contacto (tipo, valor, cliente_id)
                            VALUES (?, ?, ?)";
                
                $stmt = $this->db->prepare($sql);
                
                $stmt->bind_param("isi", $dato['tipoDato'], $dato['dato'], $id_cliente);
                
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
    
    public function actualizar() {
        
        $this->db->query("START TRANSACTION;");
        
        $calle =  ($this->calle != "") ? $this->calle : NULL;
        $numeroExterior =  ($this->numero_exterior != "") ? $this->numero_exterior : NULL;
        $numeroInterior =  ($this->numero_interior != "") ? $this->numero_interior : NULL;
        $colonia =  ($this->colonia != "") ? $this->colonia : NULL;
        $ciudad = ($this->ciudad != "") ? $this->ciudad : NULL;
        $estado = ($this->estado != "") ? $this->estado : NULL;
        $codigoPostal = ($this->codigo_postal != "") ? $this->codigo_postal : NULL;
        $urlMapa = ($this->url_mapa != "") ? $this->url_mapa : NULL;
        $rfc = ($this->rfc != "") ? $this->rfc : NULL;
        $estatus = ($this->estatus != "") ? $this->estatus : NULL;
        
        $sql = "UPDATE cliente SET nombre = ?, apellidos = ?, calle = ?,
                    numero_exterior = ?, numero_interior = ?, colonia = ?, 
                    ciudad = ?, estado = ?, codigo_postal = ?, url_mapa = ?, rfc = ?, estatus = ?
            WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssssssisssii",$this->nombre,$this->apellidos,$calle,$numeroExterior,$numeroInterior,
            $colonia,$ciudad,$estado,$codigoPostal,$urlMapa,$rfc,$estatus,$this->id);
        
        if($stmt->execute()) {
            
            // Borramos todo los datos de contacto previos e insertamos los que se enviaron en el formulario de enviar
            $sql = "DELETE FROM dato_contacto WHERE cliente_id = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $this->id);
            
            if($stmt->execute()){
                foreach ($this->datos_contacto as $dato){
                    $sql = "INSERT INTO dato_contacto (tipo, valor, cliente_id)
                            VALUES (?, ?, ?)";
                    
                    $stmt = $this->db->prepare($sql);
                    
                    $stmt->bind_param("isi", $dato['tipoDato'], $dato['dato'], $this->id);
                    
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
        }
        
        $stmt->close();
        $this->db->query("COMMIT;");
        return true;
    }
    
    /**
     * 
     * @return int 0 si falló la consulta, 1 si se eliminó el producto y los registros asociados (categorías, insumos, impuestos) y 2 si solo se desactivó porque ya está en comandas
     */
    public function eliminar() : int{
        
        $sql = "SELECT COUNT(id) AS CantidadEnComandas FROM comanda WHERE cliente_id = $this->id";
        
        $resultadoCantidadComandas = $this->db->query($sql);
        
        $cantidadEnComandas = 0;
        if($resultadoCantidadComandas->num_rows > 0) {
            $cantidadEnComandas = $resultadoCantidadComandas->fetch_object()->CantidadEnComandas;
        }
        
        if($cantidadEnComandas > 0 ){
            // Marcamos el producto como inactivo
            $sql = "UPDATE cliente SET estatus = 0 WHERE id = $this->id";
            
            if($this->db->query($sql)) {
                return 2;
            }
            
            return 0;
        } else {
            $this->db->query("START TRANSACTION;");
            
            if(!$this->db->query("DELETE FROM dato_contacto WHERE cliente_id = $this->id")){
                $this->db->query("ROLLBACK;");
                return 0;
            }
            
            if(!$this->db->query("DELETE FROM cliente WHERE id = $this->id")){
                $this->db->query("ROLLBACK;");
                return 0;
            }
            
            $this->db->query("COMMIT;");
            return 1;
        }
    }
}

