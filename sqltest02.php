<?php // sqltest02.php
require_once 'login.php';

echo '<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<title>SQL Teste</title></head><body class="bg-light">';

try {
  $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
  throw new PDOException($e->getMessage(), (int)$e->getCode());
}

if (isset($_POST['delete']) && isset($_POST['isbn'])) {
  $isbn   = sanitize_post_value($pdo, 'isbn');
  $query  = "DELETE FROM classics WHERE isbn=$isbn";
  $result = $pdo->query($query);
}

if (
  isset($_POST['author']) &&
  isset($_POST['title']) &&
  isset($_POST['category']) &&
  isset($_POST['year']) &&
  isset($_POST['isbn'])
) {
  $author   = sanitize_post_value($pdo, 'author');
  $title    = sanitize_post_value($pdo, 'title');
  $category = sanitize_post_value($pdo, 'category');
  $year     = sanitize_post_value($pdo, 'year');
  $isbn     = sanitize_post_value($pdo, 'isbn');

  $query    = "INSERT INTO classics VALUES($author, $title, $category, $year, $isbn)";
  $result = $pdo->query($query);
}

// Formulário Bootstrap
echo <<<HTML
<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">Adicionar Livro</div>
    <div class="card-body">
      <form action="sqltest.php" method="post">
        <div class="mb-3">
          <label class="form-label">Autor</label>
          <input type="text" class="form-control" name="author">
        </div>
        <div class="mb-3">
          <label class="form-label">Título</label>
          <input type="text" class="form-control" name="title">
        </div>
        <div class="mb-3">
          <label class="form-label">Categoria</label>
          <input type="text" class="form-control" name="category">
        </div>
        <div class="mb-3">
          <label class="form-label">Ano</label>
          <input type="text" class="form-control" name="year">
        </div>
        <div class="mb-3">
          <label class="form-label">ISBN</label>
          <input type="text" class="form-control" name="isbn">
        </div>
        <button type="submit" class="btn btn-success">Adicionar Registro</button>
      </form>
    </div>
  </div>
</div>
HTML;

$query  = "SELECT * FROM classics";
$result = $pdo->query($query);

echo '<div class="container mt-4">';
echo '<div class="card"><div class="card-header bg-secondary text-white">Registros</div><div class="card-body p-0">';
echo '<table class="table table-striped mb-0"><thead><tr><th>Autor</th><th>Título</th><th>Categoria</th><th>Ano</th><th>ISBN</th><th>Ação</th></tr></thead><tbody>';

while ($row = $result->fetch()) {
  $r0 = htmlspecialchars($row['author']);
  $r1 = htmlspecialchars($row['title']);
  $r2 = htmlspecialchars($row['category']);
  $r3 = htmlspecialchars($row['year']);
  $r4 = htmlspecialchars($row['isbn']);
  echo "<tr>"
    ."<td>$r0</td>"
    ."<td>$r1</td>"
    ."<td>$r2</td>"
    ."<td>$r3</td>"
    ."<td>$r4</td>"
    ."<td>"
    ."<form action='sqltest.php' method='post' class='d-inline'>"
    ."<input type='hidden' name='delete' value='yes'>"
    ."<input type='hidden' name='isbn' value='$r4'>"
    ."<button type='submit' class='btn btn-danger btn-sm'>Excluir</button>"
    ."</form>"
    ."</td>"
    ."</tr>";
}
echo '</tbody></table></div></div></div>';

echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>';
echo '</body></html>';

function sanitize_post_value($pdo, $var)
{
  return $pdo->quote($_POST[$var]);
}