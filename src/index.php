<?php
include "script.php";

// Se si è cliccato "modifica", carico l'utente da modificare
$utente_da_modificare = null;

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $rows = readQuery($conn, "SELECT * FROM utenti WHERE id = $id");

    if (!empty($rows)) {
        $utente_da_modificare = $rows[0];
    }
}

// Leggo tutti gli utenti per la tabella
$utenti = readQuery($conn, "SELECT * FROM utenti");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestione utenti</title>
</head>
<body>

<h1>Gestione Utenti</h1>

<!-- ============================ -->
<!-- FORM INSERIMENTO -->
<!-- ============================ -->
<?php if ($utente_da_modificare === null): ?>
<h2>Inserisci nuovo utente</h2>

<form method="POST" action="script.php">
    Nome:<br>
    <input type="text" name="nome" required><br><br>

    Email:<br>
    <input type="email" name="email" required><br><br>

    <button type="submit" name="insert">Inserisci</button>
</form>

<?php endif; ?>



<!-- ============================ -->
<!-- FORM MODIFICA -->
<!-- ============================ -->
<?php if ($utente_da_modificare !== null): ?>

<h2>Modifica utente</h2>

<form method="POST" action="script.php">

    <input type="hidden" name="edit_id" value="<?= $utente_da_modificare['id'] ?>">

    Nome:<br>
    <input type="text" name="edit_name" value="<?= $utente_da_modificare['nome'] ?>" required><br><br>

    Email:<br>
    <input type="email" name="edit_email" value="<?= $utente_da_modificare['email'] ?>" required><br><br>

    <button type="submit" name="edit">Salva Modifica</button>
</form>

<br>
<a href="index.php">Annulla</a>

<?php endif; ?>



<!-- ============================ -->
<!-- TABELLA UTENTI -->
<!-- ============================ -->
<h2>Lista utenti</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Azioni</th>
    </tr>

    <?php foreach ($utenti as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= $u['nome'] ?></td>
            <td><?= $u['email'] ?></td>
            <td>
                <a href="index.php?edit=<?= $u['id'] ?>">Modifica</a> |
                <a href="script.php?delete=<?= $u['id'] ?>" onclick="return confirm('Sei sicuro?');">Elimina</a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
