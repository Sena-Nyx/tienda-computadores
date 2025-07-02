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
      <form class="form-admin" action="index.php?accion=agregarCategoria" method="post">
        <h3>Categorías</h3>
        <input type="text" name="nombre" placeholder="Nombre de la categoría" required>
        <button type="submit">Guardar Categoría</button>

        <ul>
        <?php if(isset($categorias)){ ?>
          <?php while($cat = $categorias->fetch_object()){ ?>
            <li>
              <?php echo htmlspecialchars($cat->nombre); ?>
              <a href="index.php?accion=eliminarCategoria&id=<?php echo $cat->id; ?>" onclick="return confirm('Esta seguro que quiere eliminar esta categoria?');">
                <button type="button">Eliminar</button>
              </a>
            </li>
          <?php }; ?>
        <?php }; ?>
      </ul>
      </form>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
  </footer>
</body>
</html>