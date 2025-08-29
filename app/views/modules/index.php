<h1>Liste des Modules</h1>

<ul>
  <?php foreach ($modules as $module): ?>
    <li>
      <strong><?= htmlspecialchars($module['name']) ?></strong> — 
      <?= htmlspecialchars($module['description']) ?>
      <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <a href="index.php?controller=module&action=delete&id=<?= $module['id'] ?>">Supprimer</a>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
</ul>

<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
  <a href="index.php?controller=module&action=create">+ Ajouter un module</a>
<?php endif; ?>