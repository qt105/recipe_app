<?php
require 'app/functions.php';
include 'templates/header.php';

$recipes = getAllRecipes();
?>

<h1>Liste des Recettes</h1>
<ul>
    <?php
    foreach ($recipes as $recipe) {
        echo "<li><a class='recipe_link' href='recipe.php?id=" . $recipe['id'] . "'>" . htmlspecialchars($recipe['name']) . "</a></li>";
    }
    ?>
</ul>

<?php
include 'templates/footer.php';
?>
