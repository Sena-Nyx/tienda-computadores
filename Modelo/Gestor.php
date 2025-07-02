<?php
class Gestor {

    public function consultarProductos() {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.imagen, c.nombre AS categoria
                FROM productos p
                JOIN categorias c ON p.id_categoria = c.id";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result;
    }

    public function validarLogin($email, $clave) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM usuarios WHERE correo = '$email' AND password = '$clave' AND rol = 'admin'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result;
    }

    public function agregarProducto(Productos $producto) {
        $conexion = new Conexion();
        $conexion->abrir();
        $nombre = $producto->obtenernombre();
        $descripcion = $producto->obtenerdescripcion();
        $precio = $producto->obtenerprecio();
        $imagen = $producto->obtenerimagen();
        $categoria = $producto->obtenercategoria();   
        $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen, id_categoria) VALUES ('$nombre', '$descripcion', '$precio', '$imagen', '$categoria')";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function consultarCategorias() {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM categorias";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result;
    }

    public function consultarProductoPorId($id) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM productos WHERE id = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result->fetch_object();
    }

    public function consultarProductosPorCategoria($id_categoria) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.imagen, c.nombre AS categoria
                FROM productos p
                JOIN categorias c ON p.id_categoria = c.id
                WHERE p.id_categoria = '$id_categoria'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }

    public function editarProductos($id, $nombre, $precio, $talla, $categoria, $imagen) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE productos SET nombre='$nombre', descripcion='$talla', precio='$precio', imagen='$imagen', id_categoria='$categoria' WHERE id='$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function eliminarProductos($id) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM productos WHERE id='$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function agregarCategorias($nombre) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO categorias (nombre) VALUES ('$nombre')";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function eliminarCategorias($id) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM categorias WHERE id='$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function consultarPedidos() {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT p.id, u.nombre AS cliente, pr.nombre AS producto, p.cantidad, p.fecha, p.estado
                FROM pedidos p
                JOIN usuarios u ON p.id_usuario = u.id
                JOIN productos pr ON p.id_producto = pr.id";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }

    public function registrarUsuario($nombre, $correo, $password, $rol) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO usuarios (nombre, correo, password, rol) VALUES ('$nombre', '$correo', '$password', '$rol')";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function buscarUsuarioCliente($correo, $password) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND password = '$password' AND rol = 'cliente'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result->fetch_object();
    }

    public function guardarPedido($id_usuario, $id_producto, $cantidad) {
        $conexion = new Conexion();
        $conexion->abrir();
        $fecha = date('Y-m-d H:i:s');
        $estado = 'pendiente';
        $sql = "INSERT INTO pedidos (id_usuario, id_producto, cantidad, fecha, estado) VALUES ('$id_usuario', '$id_producto', '$cantidad', '$fecha', '$estado')";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

}