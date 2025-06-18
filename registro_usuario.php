<?php
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
