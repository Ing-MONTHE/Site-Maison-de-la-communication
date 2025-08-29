<h1>Ajouter un module</h1>
<form method="post" action="index.php?controller=module&action=create">
  <label for="name">Nom du module</label>
  <input type="text" id="name" name="name" required>

  <label for="description">Description</label>
  <textarea id="description" name="description" required></textarea>

  <button type="submit">Enregistrer</button>
</form>
<a href="index.php?controller=module&action=index">← Retour à la liste des modules</a>