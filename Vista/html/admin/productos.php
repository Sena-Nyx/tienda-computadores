<!-- index.html -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda de Tenis</title>
  <link rel="stylesheet" href="Vista/css/styles.css">
</head>
<body>
  <header>
    <h1>Tienda de Tenis</h1>
    <nav>
      <a href="index.php?accion=mostrarAdminProductos">Productos</a>
      <a href="index.php?accion=mostrarAdminCategorias">Categorias</a>
      <a href="index.php?accion=mostrarAdminPedidos">Pedidos</a>
      <a href="index.php?accion=cerrarSesion">Cerrar sesión</a>
      <?php if (isset($_SESSION['usuario'])): ?>
        <span class="usuario-nombre"><?php echo ($_SESSION['usuario']->nombre); ?></span>
      <?php endif; ?>
    </nav>
  </header>

  <section id="panel-admin">
    <h2>Panel de Administración</h2>

    <div class="admin-section">
      <h2>Productos</h2>
      <button><a href='index.php?accion=mostrarAgregarProducto'>Agregar Producto</a></button>
      <div class="admin-section">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Categoría</th>
              <th>Precio</th>
              <th>Talla</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <?php while($prod = $productos->fetch_object()) { ?>
          <tbody>
            <tr>
              <td><?php echo $prod->id; ?></td>
              <td><?php echo $prod->nombre; ?></td>
              <td><?php echo $prod->categoria; ?></td>
              <td><?php echo $prod->precio; ?></td>
              <td><?php echo $prod->descripcion; ?></td>
              <td>
                <a href="index.php?accion=mostrarEditarProducto&id=<?php echo $prod->id; ?>"><button>Editar</button></a>
                  <a href="index.php?accion=eliminarProducto&id=<?php echo $prod->id; ?>" onclick="return confirm('Esta seguro que quiere eliminar esta productoahor?');"><button>Eliminar</button></a>

              </td>
            </tr>
          </tbody>
          <?php } ?>
        </table>
      </div>
  </section>

  <footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
  </footer>
</body>
</html>


