<!-- archivo: registro.html -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
  <link rel="stylesheet" href="css/estilos.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #667eea, #764ba2);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .form-container {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 400px;
    }
    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      margin-bottom: 15px;
    }
    button {
      width: 100%;
      padding: 12px;
      border: none;
      background-color: #00c9a7;
      color: white;
      font-size: 16px;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    button:hover {
      background-color: #00a88a;
    }
  </style>
  <script>
    function validarFormulario() {
      const usuario = document.forms["registroForm"]["usuario"].value;
      const clave = document.forms["registroForm"]["clave"].value;

      if (usuario.length < 4) {
        alert("El nombre de usuario debe tener al menos 4 caracteres.");
        return false;
      }
      if (clave.length < 6) {
        alert("La contraseña debe tener al menos 6 caracteres.");
        return false;
      }
      return true;
    }
  </script>
</head>
<body>
  <div class="form-container">
    <h2>Registrar nuevo usuario</h2>
    <form name="registroForm" action="registro_usuario.php" method="POST" onsubmit="return validarFormulario()">
      <label>Nombre de usuario:</label>
      <input type="text" name="usuario" required>

      <label>Contraseña:</label>
      <input type="password" name="clave" required>

      <button type="submit">Registrar</button>
    </form>
  </div>
</body>
</html>


<?php
// archivo: registro_usuario.php
include("conexion.php");

$usuario = $_POST['usuario'];
$clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);

// Verificar si el usuario ya existe
$sql_check = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt_check = $conexion->prepare($sql_check);
$stmt_check->bind_param("s", $usuario);
$stmt_check->execute();
$resultado = $stmt_check->get_result();

if ($resultado->num_rows > 0) {
  echo "<p>El usuario ya existe. <a href='registro.html'>Intentar otro</a></p>";
} else {
  // Insertar nuevo usuario
  $sql = "INSERT INTO usuarios (usuario, clave) VALUES (?, ?)";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("ss", $usuario, $clave);

  if ($stmt->execute()) {
    echo "<p>Usuario registrado correctamente. <a href='login.html'>Iniciar sesión</a></p>";
  } else {
    echo "Error: " . $conexion->error;
  }
}
?>
