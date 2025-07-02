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
      <?php if (isset($_SESSION['usuario'])){ ?>
        <span class="usuario-nombre"><?php echo ($_SESSION['usuario']->nombre); ?></span>
      <?php } ?>
    </nav>
  </header>

  <section id="panel-admin">
    <h2>Panel de Administración</h2>

    <div class="admin-section">
      <h3>Agregar Productos</h3>

      <form class="form-admin" action="index.php?accion=agregarProducto" method="post" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <input type="number" name="precio" placeholder="Precio" required>
        <input type="text" name="descripcion" placeholder="Talla" required>
        <select name="categoria" required>
          <option value="">Seleccionar categoría</option>
          <?php
            if(isset($categorias)){
              while($cat = $categorias->fetch_object()){
                echo "<option value='{$cat->id}'>{$cat->nombre}</option>";
              }
            }
          ?>
        </select>
        <input type="file" name="imagen" required>
        <button type="submit">Guardar Producto</button>
      </form>
      
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
  </footer>
</body>
</html>


