<?php
// ===============================
// CONNESSIONE AL DATABASE
// ===============================
$servername = 'db';
$username   = 'myuser';
$password   = 'mypassword';
$database   = 'myapp_db';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}



// ===============================
// FUNZIONI CRUD
// ===============================

// READ QUERY (Select generica)
function readQuery($conn, $query) {
    $data = [];
    $res = $conn->query($query);

    if ($res === false) {
        echo "Errore query: " . $conn->error;
        return $data;
    }

    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// INSERT
function insertUser($conn, $nome, $email) {
    $nome  = $conn->real_escape_string($nome);
    $email = $conn->real_escape_string($email);

    $conn->query("INSERT INTO utenti (nome, email) VALUES ('$nome', '$email')");
}

// UPDATE
function updateUser($conn, $id, $nome, $email) {
    $id    = intval($id);
    $nome  = $conn->real_escape_string($nome);
    $email = $conn->real_escape_string($email);

    $conn->query("UPDATE utenti SET nome='$nome', email='$email' WHERE id=$id");
}

// DELETE
function deleteUser($conn, $id) {
    $id = intval($id);
    $conn->query("DELETE FROM utenti WHERE id=$id");
}



// ===============================
// GESTIONE OPERAZIONI DA FORM
// ===============================

// INSERT
if (isset($_POST['insert'])) {
    insertUser($conn, $_POST['nome'], $_POST['email']);
    header("Location: index.php");
    exit;
}

// UPDATE
if (isset($_POST['edit'])) {
    updateUser($conn, $_POST['edit_id'], $_POST['edit_name'], $_POST['edit_email']);
    header("Location: index.php");
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    deleteUser($conn, $_GET['delete']);
    header("Location: index.php");
    exit;
}

?>
