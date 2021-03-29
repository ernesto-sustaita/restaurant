<?php
namespace model;

use database\DB;

/**
 *
 * @author ernesto
 *        
 */
class Producto
{
    private $db;
    private $id;
    private $nombre;
    private $precio;
    private $estatus;
    private $datosInsumos; 
    private $datosImpuestos; 
    private $datosCategorias;
    
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
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
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
    public function getDatosInsumos()
    {
        return $this->datosInsumos;
    }

    /**
     * @return array
     */
    public function getDatosImpuestos()
    {
        return $this->datosImpuestos;
    }

    /**
     * @return array
     */
    public function getDatosCategorias()
    {
        return $this->datosCategorias;
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
     * @param float $precio
     */
    public function setPrecio(float $precio)
    {
        $this->precio = $this->db->escape($precio);
    }

    /**
     * @param int $estatus
     */
    public function setEstatus(int $estatus)
    {
        $this->estatus = $this->db->escape($estatus);
    }

    /**
     * @param array $datosInsumo
     */
    public function setDatosInsumos(array $datosInsumos)
    {
        $this->datosInsumos = $datosInsumos;
    }

    /**
     * @param array $datosImpuestos
     */
    public function setDatosImpuestos(array $datosImpuestos)
    {
        $this->datosImpuestos = $datosImpuestos;
    }

    /**
     * @param array $datosCategorias
     */
    public function setDatosCategorias(array $datosCategorias)
    {
        $this->datosCategorias = $datosCategorias;
    }

    public function __construct(){
        $this->db = DB::getInstance();
    }
    
    public function consultar(){
        $sql = "SELECT id, nombre, precio, estatus FROM producto ORDER BY nombre";
        
        return $this->db->query($sql);
    }
    
    public function consultarActivos(){
        $sql = "SELECT id, nombre, precio, estatus FROM producto WHERE estatus = 1 ORDER BY nombre";
        
        return $this->db->query($sql);
    }
    
    public function consultarImpuestosPorProducto(){
        $sql = "SELECT impuesto.id, impuesto.nombre, impuesto.porcentaje 
                    FROM impuesto
                    INNER JOIN producto_impuesto ON impuesto.id = producto_impuesto.impuesto_id
                    WHERE producto_impuesto.producto_id = $this->id AND impuesto.estatus = 1";
        
        return  $this->db->query($sql);
    }
    
    public function consultarCategoriasPorProducto(){
        $sql = "SELECT categoria.id, categoria.nombre
                    FROM categoria
                    INNER JOIN producto_categoria ON categoria.id = producto_categoria.categoria_id
                    WHERE producto_categoria.producto_id = $this->id AND categoria.estatus = 1";
        
        return  $this->db->query($sql);
    }
    
    public function consultarInsumosPorProducto(){
        $sql = "SELECT insumo.id, insumo.nombre
                    FROM insumo
                    INNER JOIN producto_insumo ON insumo.id = producto_insumo.insumo_id
                    WHERE producto_insumo.producto_id = $this->id AND insumo.estatus = 1";
        
        return  $this->db->query($sql);
    }
    
    public function filtrar($filtro){
        
        $filtro = $this->db->escape($filtro);
        
        $sql = "SELECT id, nombre, precio, estatus 
                    FROM producto WHERE nombre LIKE '%" . $filtro . "%' ORDER BY nombre";
        
        return $this->db->query($sql);
    }
    
    public function filtrarActivos($filtro){
        
        $filtro = $this->db->escape($filtro);
        
        $sql = "SELECT id, nombre, precio, estatus
                    FROM producto WHERE nombre LIKE '%" . $filtro . "%' AND estatus = 1 ORDER BY nombre";
        
        return $this->db->query($sql);
    }
    
    public function filtrarPorCategoria($idCategoria){
        
        $idCategoria = $this->db->escape($idCategoria);
        
        $sql = "SELECT id, nombre, precio, estatus
                    FROM producto WHERE id IN (SELECT DISTINCT producto_id FROM producto_categoria WHERE categoria_id = " . $idCategoria . ") ORDER BY nombre";
        
        return $this->db->query($sql);
    }
    
    public function filtrarActivosPorCategoria($idCategoria){
        
        $idCategoria = $this->db->escape($idCategoria);
        
        $sql = "SELECT id, nombre, precio, estatus
                    FROM producto WHERE id IN (SELECT DISTINCT producto_id FROM producto_categoria WHERE categoria_id = " . $idCategoria . ") AND estatus = 1 ORDER BY nombre";
        
        return $this->db->query($sql);
    }
    
    public function consultarPorId(){
        $sql = "SELECT id, nombre, precio, estatus
                    FROM producto WHERE id = $this->id";
        
        return $this->db->query($sql);
    }
    
    public function ordenar($tipoFiltro){
        
        $tipoFiltro = $this->db->escape($tipoFiltro);
        
        $filtro = "";
        
        switch ($tipoFiltro){
            case "1":
                $filtro = " nombre";
                break;
            case "2":
                $filtro = " nombre DESC";
                break;
            case "3":
                $filtro = " precio";
                break;
            case "4":
                $filtro = " precio DESC";
                break;
        }
        
        $sql = "SELECT id, nombre, precio, estatus
                    FROM producto ORDER BY" . $filtro;
        
        return $this->db->query($sql);
    }
    
    public function ordenarActivos($tipoFiltro){
        
        $tipoFiltro = $this->db->escape($tipoFiltro);
        
        $filtro = "";
        
        switch ($tipoFiltro){
            case "1":
                $filtro = " nombre";
                break;
            case "2":
                $filtro = " nombre DESC";
                break;
            case "3":
                $filtro = " precio";
                break;
            case "4":
                $filtro = " precio DESC";
                break;
        }
        
        $sql = "SELECT id, nombre, precio, estatus
                    FROM producto WHERE estatus = 1 ORDER BY" . $filtro;
        
        return $this->db->query($sql);
    }
    
    public function crear() {
        $this->db->query("START TRANSACTION;");
        
        $estatus = ($this->estatus != "") ? $this->estatus : NULL; 
        
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
    
    public function actualizar() {
        $this->db->query("START TRANSACTION;");
        
        $estatus = ($this->estatus != "") ? $this->estatus : NULL;
        
        $sql = "UPDATE producto SET nombre = ?, precio = ?, estatus = ?
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sdii",$this->nombre,$this->precio,$estatus, $this->id);
        
        if($stmt->execute()) {
            
            $sql = "DELETE FROM producto_insumo WHERE producto_id = ?";
            
            $stmt = $this->db->prepare($sql);
            
            $stmt->bind_param("i", $this->id);
            
            if(!$stmt->execute()){
                $this->db->query("ROLLBACK;");
                $stmt->close();
                return false;
            }
            
            foreach ($this->datosInsumos as $insumo){
                $sql = "INSERT INTO producto_insumo (producto_id, insumo_id, cantidad)
                            VALUES (?, ?, ?)";
                
                $stmt = $this->db->prepare($sql);
                
                $stmt->bind_param("iii", $this->id, $insumo['idInsumo'], $insumo['cantidad']);
                
                if(!$stmt->execute()){
                    $this->db->query("ROLLBACK;");
                    $stmt->close();
                    return false;
                }
            }
            
            $sql = "DELETE FROM producto_impuesto WHERE producto_id = ?";
            
            $stmt = $this->db->prepare($sql);
            
            $stmt->bind_param("i", $this->id);
            
            if(!$stmt->execute()){
                $this->db->query("ROLLBACK;");
                $stmt->close();
                return false;
            }
            
            foreach ($this->datosImpuestos as $impuesto){
                $sql = "INSERT INTO producto_impuesto (producto_id, impuesto_id)
                            VALUES (?, ?)";
                
                $stmt = $this->db->prepare($sql);
                
                $stmt->bind_param("ii", $this->id, $impuesto['idImpuesto']);
                
                if(!$stmt->execute()){
                    $this->db->query("ROLLBACK;");
                    $stmt->close();
                    return false;
                }
            }
            
            $sql = "DELETE FROM producto_categoria WHERE producto_id = ?";
            
            $stmt = $this->db->prepare($sql);
            
            $stmt->bind_param("i", $this->id);
            
            if(!$stmt->execute()){
                $this->db->query("ROLLBACK;");
                $stmt->close();
                return false;
            }
            
            foreach ($this->datosCategorias as $categoria){
                $sql = "INSERT INTO producto_categoria (producto_id, categoria_id)
                            VALUES (?, ?)";
                
                $stmt = $this->db->prepare($sql);
                
                $stmt->bind_param("ii", $this->id, $categoria['idCategoria']);
                
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
    
    /**
     * 
     * @return int 0 si falló la consulta, 1 si se eliminó el producto y los registros asociados (categorías, insumos, impuestos) y 2 si solo se desactivó porque ya está en comandas
     */
    public function eliminar() : int{
        /* 1. Revisar si no está ya en alguna comanda (en caso contrario, solo se marca como inactivo, pero no se elimina)
         * 2. Eliminar todas las asociasiones que tenga con categorías, insumos e impuestos 
         * 3. Eliminar el producto 8*/
        $sql = "SELECT COUNT(id) AS CantidadEnComandas FROM comanda_producto WHERE producto_id = $this->id";
        
        $resultadoCantidadComandas = $this->db->query($sql);
        
        $cantidadEnComandas = 0;
        if($resultadoCantidadComandas->num_rows > 0) {
            $cantidadEnComandas = $resultadoCantidadComandas->fetch_object()->CantidadEnComandas;
        }
        
        if($cantidadEnComandas > 0 ){
            // Marcamos el producto como inactivo 
            $sql = "UPDATE producto SET estatus = 0 WHERE id = $this->id";
            
            if($this->db->query($sql)) {
                return 2;
            }
            
            return 0; 
        } else {
            $this->db->query("START TRANSACTION;");
            
            if(!$this->db->query("DELETE FROM producto_categoria WHERE producto_id = $this->id")){
                $this->db->query("ROLLBACK;");
                return 0;
            }
            
            if(!$this->db->query("DELETE FROM producto_insumo WHERE producto_id = $this->id")){
                $this->db->query("ROLLBACK;");
                return 0;
            }
            
            if(!$this->db->query("DELETE FROM producto_impuesto WHERE producto_id = $this->id")){
                $this->db->query("ROLLBACK;");
                return 0;
            }
            
            if(!$this->db->query("DELETE FROM producto WHERE id = $this->id")){
                $this->db->query("ROLLBACK;");
                return 0;
            }
            
            $this->db->query("COMMIT;");
            return 1;
         }
    }
    
    public function obtenerCantidadProductosVendidosHoy() : array {
        $sql = "SELECT DISTINCT(producto_id) AS id FROM comanda_producto INNER JOIN comanda ON comanda.id = comanda_producto.comanda_id WHERE FROM_UNIXTIME(comanda.fecha_hora, '%Y-%m-%d') = CURDATE()";
        $resultadoIdsProductosVendidosHoy = $this->db->query($sql);
        
        $datosProductos = array();
        while ($producto = $resultadoIdsProductosVendidosHoy->fetch_object()) {
            $sql = "SELECT producto.nombre, SUM(comanda_producto.cantidad) AS cantidad FROM comanda_producto 
                        INNER JOIN comanda ON comanda.id = comanda_producto.comanda_id 
                        INNER JOIN producto ON producto.id = comanda_producto.producto_id 
                        WHERE FROM_UNIXTIME(comanda.fecha_hora, '%Y-%m-%d') = CURDATE() AND producto.id = $producto->id
                            AND comanda.pagada = 1";

            $resultadoCantidadProductos = $this->db->query($sql);
            
            if($resultadoCantidadProductos->num_rows > 0) {
                array_push($datosProductos, $resultadoCantidadProductos->fetch_assoc());
            }
        }
        
        return $datosProductos;
    }
}

