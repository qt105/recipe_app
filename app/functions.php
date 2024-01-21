<?php
require_once 'config/database.php';

function getAllRecipes() {
    global $pdo;
    
    try {
        $sql = "SELECT id, name FROM recipes";
        $query = $pdo->prepare($sql);
        $query->execute();
        $recipes = $query->fetchAll(PDO::FETCH_ASSOC);
        return $recipes;
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function getRecipe($id) {
    global $pdo;

    try {
        $sql = "SELECT * FROM recipes WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $recipe = $query->fetch(PDO::FETCH_ASSOC);
        return $recipe;
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

?>
