<?php
class Controlador{
    public function verPagina($ruta){
        require_once $ruta;
    }

    /* Catalogo */
    public function mostrarCatalogo(){
        $gestor = new Gestor();
        $categoria = $gestor->consultarCategorias();
        $productos = $gestor->consultarProductos();
        require 'Vista/html/catalogo.php';
    }

    public function filtrarCategorias($categoria){
        $gestor = new Gestor();
        if (empty($categoria)) {
            $productos = $gestor->consultarProductos();
        } else {
            $productos = $gestor->consultarProductosPorCategoria($categoria);
        }
        $categoria = $gestor->consultarCategorias();
        require 'Vista/html/catalogo.php';
    }
    /* Fin Catalogo */

    /* Login */
    public function requireLogin() {
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit();
        }
    }

    public function procesarLogin($correo, $password) {
        $gestor = new Gestor();
        $result = $gestor->validarLogin($correo, $password);
        $usuario = $result->fetch_object();

        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php?accion=mostrarAdminProductos");
            exit;

        } else {
            header("Location: index.php?accion=login&error=1");
            exit;
        }
    }
    /* Fin Login */

    /* Productos */
    public function mostrarProductos() {
        $gestor = new Gestor();
        $productos = $gestor->consultarProductos();
        require 'Vista/html/admin/productos.php';
    }

    public function mostrarAgregarProducto() {
        $gestor = new Gestor();
        $categorias = $gestor->consultarcategorias();
        require 'Vista/html/admin/agregarProductos.php';
    }

    public function agregarProducto($nombre, $precio, $descripcion, $categoria, $imagen) {

        /* Subir Imagen */
        $ruta_indexphp = "Uploads";
        $extensiones = array('image/jpg', 'image/jpeg', 'image/png', 'image/webp');
        $max_tamanyo = 1024 * 1024 * 8; 
        $nombre_imagen = basename($imagen['name']);
        $ruta_fichero_origen = $imagen['tmp_name'];
        $ruta_nuevo_destino = $ruta_indexphp . '/' . $nombre_imagen;

        if (in_array($imagen['type'], $extensiones)) {
            echo "Es una imagen";
            if ($imagen['size'] < $max_tamanyo) {
                echo "Pesa menos de 1MB";
                if (move_uploaded_file($ruta_fichero_origen, $ruta_nuevo_destino)) {
                    echo "Fichero guardado con éxito";
                }
            }
        }
        $producto = new Productos($nombre, $precio, $descripcion, $ruta_nuevo_destino, $categoria);

        $gestor = new Gestor();
        $gestor->agregarProducto($producto);

        header("Location: index.php?accion=mostrarAdminProductos");
        exit;
    }

    public function mostrarEditarProducto($id) {
        $gestor = new Gestor();
        $producto = $gestor->consultarProductoPorId($id);
        $categorias = $gestor->consultarCategorias();
        require 'Vista/html/admin/editarProductos.php';
    }

    public function editarProductos($post, $files) {
        $id = $post['id'];
        $nombre = $post['nombre'];
        $precio = $post['precio'];
        $talla = $post['talla'];
        $categoria = $post['categoria'];
        $imagen = $files['imagen'];

        $gestor = new Gestor();
        $producto = $gestor->consultarProductoPorId($id);
        $ruta_imagen = $producto->imagen;

        /* repetir subir imagen */
        if ($imagen['name']) {
            $ruta_indexphp = "Uploads";
            $extensiones = array('image/jpg', 'image/jpeg', 'image/png', 'image/webp');
            $max_tamanyo = 1024 * 1024 * 8;
            $nombre_imagen = basename($imagen['name']);
            $ruta_fichero_origen = $imagen['tmp_name'];
            $ruta_nuevo_destino = $ruta_indexphp . '/' . $nombre_imagen;
            if (in_array($imagen['type'], $extensiones) && $imagen['size'] < $max_tamanyo) {
                if (move_uploaded_file($ruta_fichero_origen, $ruta_nuevo_destino)) {
                    $ruta_imagen = $ruta_nuevo_destino;
                }
            }
        }

        $gestor->editarProductos($id, $nombre, $precio, $talla, $categoria, $ruta_imagen);
        header("Location: index.php?accion=mostrarAdminProductos");
        exit;
    }

    public function eliminarProductos($id) {
        $gestor = new Gestor();
        $producto = $gestor->consultarProductoPorId($id);
        if ($producto && file_exists($producto->imagen)) {
            unlink($producto->imagen); 
        }
        $gestor->eliminarProductos($id);
        header("Location: index.php?accion=mostrarAdminProductos");
        exit;
    }
    /* Fin Productos */

    /* Categorias */
    public function mostrarCategorias() {
        $gestor = new Gestor();
        $categorias = $gestor->consultarCategorias();
        require 'Vista/html/admin/categorias.php';
    }

    public function agregarCategorias($post) {
        $nombre = $post['nombre'];
        $gestor = new Gestor();
        $gestor->agregarCategorias($nombre);
        header("Location: index.php?accion=mostrarAdminCategorias");
        exit;
    }

    public function eliminarCategorias($id) {
        $gestor = new Gestor();
        $gestor->eliminarCategorias($id);
        header("Location: index.php?accion=mostrarAdminCategorias");
        exit;
    }
    /* Fin Categorias */

    /* Pedidos */
    public function mostrarPedidos() {
        $gestor = new Gestor();
        $pedidos = $gestor->consultarPedidos();
        require 'Vista/html/admin/pedidos.php';
    }

    public function mostrarFormularioPedido($id_producto) {
        $gestor = new Gestor();
        $producto = $gestor->consultarProductoPorId($id_producto);
        require 'Vista/html/solicitarPedido.php';
    }

    public function guardarPedido($post) {
        $correo = $post['correo'];
        $password = $post['password'];
        $id_producto = $post['id_producto'];
        $cantidad = $post['cantidad'];

        $gestor = new Gestor();
        $usuario = $gestor->buscarUsuarioCliente($correo, $password);
        if ($usuario) {
            $gestor->guardarPedido($usuario->id, $id_producto, $cantidad);
            header("Location: index.php?mensaje=pedido_ok");
            exit;
        } else {
            header("Location: index.php?mensaje=usuario_no_encontrado");
            exit;
        }
    }
    /* Fin Pedidos */

    /* Registro */
    public function mostrarRegister() {
        $gestor = new Gestor();
        require 'Vista/html/registro.php';
    }

    public function registrarUsuario($post) {
        $nombre = $post['nombre'];
        $correo = $post['correo'];
        $password = $post['password'];
        $rol = 'cliente';

        $gestor = new Gestor();
        $gestor->registrarUsuario($nombre, $correo, $password, $rol);
        header("Location: index.php");
        exit;
    }
    /* Fin registro */
}

?>
