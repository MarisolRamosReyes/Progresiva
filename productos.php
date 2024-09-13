<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to bottom right, #FFCDD2, #FF4081);
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      color: white;
    }
    .container {
      margin-top: 20px;
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      width: 90%;
      max-width: 1200px;
    }
    .barra-tabla {
      background-color: #FF4081; /* Fondo rosa fuerte para la barra de tabla */
      color: white; /* Texto blanco */
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 20px;
    }
    .table-custom thead th {
      background-color: #FF4081; /* Fondo rosa fuerte para encabezados de tabla */
      color: white; /* Texto blanco */
    }
    .table-custom tbody td {
      background-color: #FFEBEE; /* Fondo rosa claro para celdas de tabla */
    }
    button {
      background-color: #FF4081;
      border: none;
      border-radius: 25px;
      color: white;
      padding: 15px 30px;
      font-size: 1em;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.3s;
    }
    button:hover {
      background-color: #E91E63;
      transform: scale(1.05);
    }
    .modal-content {
      background-color: #FF4081;
      color: white;
    }
    .modal-footer .btn-secondary {
      background-color: #E91E63;
      border: none;
    }
    .modal-footer .btn-danger {
      background-color: #D32F2F;
      border: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="barra-tabla">
      <h1 class="text-center">Lista de Productos</h1>
      <button onclick="window.location.href='AgregarProduct.php'">Agregar Producto</button>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-custom">
        <thead>
          <tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad en Stock</th>
            <th>Categoría</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'conexion.php';

          // Consulta SQL para obtener los productos
          $sql = "SELECT idProducto, nombre, descripcion, precio, stock, categoria FROM productos WHERE estatus = 1";
          $result = $conn->query($sql);
          
          if ($result->num_rows > 0) {
            // Mostrar los datos en la tabla HTML
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['idProducto'] . "</td>";
              echo "<td>" . $row['nombre'] . "</td>";
              echo "<td>" . $row['descripcion'] . "</td>";
              echo "<td>" . $row['precio'] . "</td>";
              echo "<td>" . $row['stock'] . "</td>";
              echo "<td>" . $row['categoria'] . "</td>";
              echo "<td>";
              echo "<a href='ModificarProduct.php?id=" . $row['idProducto'] . "' class='btn btn-warning btn-sm'><i class='fas fa-pencil-alt'></i></a> ";
              echo "<button type='button' class='btn btn-danger btn-sm' onclick='openConfirmModal(" . $row['idProducto'] . ")'><i class='fas fa-trash'></i></button>";
              echo "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='7'>No se encontraron productos</td></tr>";
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal de confirmación -->
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">Confirmar Eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que quieres eliminar este producto?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a id="deleteProductLink" href="#" class="btn btn-danger">Eliminar</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function openConfirmModal(idProducto) {
      var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
      var url = 'EliminarProductPHP.php?id=' + idProducto;
      document.getElementById('deleteProductLink').setAttribute('href', url);
      confirmModal.show();
    }
  </script>
  

</body>
</html>
