<?php 
require 'config/database.php';

$servername = DB_HOST;
$username = DB_USER;
$password = DB_PASS;
$dbname = DB_NAME;

$errors = array('name' => '', 'description' => '', 'ingredients' => '', 'steps' => '');
$name = $description = $ingredients = $steps = '';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['name']);
        $description = htmlspecialchars($_POST['description']);
        $ingredients = htmlspecialchars($_POST['ingredients']);
        $steps = htmlspecialchars($_POST['steps']);

        if (strlen($name) > 255) {
            $errors['name'] = "Le titre est trop long.";
        } elseif (!preg_match("/^[a-zA-Z0-9,.\s]+$/", $name)) {
            $errors['name'] = "Utilisez seulement des lettres, numéros, virgules et espaces pour le titre de votre recette";
        }

        if (strlen($description) > 65535) {
            $errors['description'] = "La description est trop longue.";
        } elseif (!preg_match("/^[a-zA-Z0-9,;.\s]+$/", $description)) {
            $errors['description'] = "Utilisez seulement des lettres, numéros, virgules, point virgules, points et espaces pour la description de votre recette";
        }

        if (strlen($ingredients) > 65535) {
            $errors['ingredients'] = "la liste d'ingrédients est trop longue.";
        } elseif (!preg_match("/^[a-zA-Z0-9,;.\s]+$/", $ingredients)) {
            $errors['ingredients'] = "Utilisez seulement des lettres, numéros, virgules, point virgules, points et espaces pour les ingrédients de votre recette";
        }

        if (strlen($steps) > 65535) {
            $errors['steps'] = "la liste d'étapes est trop longue.";
        } elseif (!preg_match("/^[a-zA-Z0-9,;.\s]+$/", $steps)) {
            $errors['steps'] = "Utilisez seulement des lettres, numéros, virgules, point virgules, points et espaces pour les étapes de votre recette";
        }

        if (!array_filter($errors)) {
            $sql = "INSERT INTO recipes (name, description, ingredients, steps) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([$name, $description, $ingredients, $steps])) {
                // Reset the variables after successful insertion
                $name = $description = $ingredients = $steps = '';
        }
    }
}
} catch(PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    echo "Veuillez nous excuser, nous présentons des difficultées techniques. Veuillez réessayer ultérieurement";
}

$conn = null;

require 'app/functions.php';
include 'templates/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"> 
    <title>Mon Site de Recettes</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Recipe Form</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="error"><?php echo $errors['name']; ?></div>
        Titre:<input required="required" type="text" name="name" maxlength="255" value="<?php echo $name; ?>">
        <div class="error"><?php echo $errors['description']; ?></div>
        Description:<textarea required="required" name="description" rows="5"><?php echo $description; ?></textarea>
        <div class="error"><?php echo $errors['ingredients']; ?></div>
        Ingredients:<textarea required="required" name="ingredients" rows="5" placeholder="Impératif de séparer chaque ingrédient par un point virgule (;)"><?php echo $ingredients; ?></textarea>
        <div class="error"><?php echo $errors['steps']; ?></div>
        Étapes:<textarea required="required" name="steps" rows="5" placeholder="Impératif de séparer chaque étape par un point virgule (;)"><?php echo $steps; ?></textarea>
        <input type="submit" name="submit" value="Submit" class="submit-button">  
    </form>
</body>
</html>

<?php 
include 'templates/footer.php';
?>
