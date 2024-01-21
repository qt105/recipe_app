<?php
include 'templates/header.php';

$songs = [
    'audiofiles/onlymp3.to_-_careless_whisper_low_quality-ZA3-dgMPnL4-192k-1705408653.mp3',
    'audiofiles/onlymp3.to_-_low_quality_gangam_style-lRxRaZz3sGU-192k-1705408673.mp3',
    'audiofiles/onlymp3.to_-_shape_of_you_but_its_low_quality-0dJKIcAdJeA-192k-1705408613.mp3'
];

$randomSong = $songs[array_rand($songs)];
?>

<audio id="backgroundMusic" loop hidden>
    <source src="<?php echo $randomSong; ?>" type="audio/mpeg">
</audio>
<button onclick="playMusic()">Cliquer pour du bonheur</button>
<h1>Hello there!</h1>
<p>Bienvenue sur mon super site de recettes, on va s'en mettre plein la panse!</p>
<img src="https://st.depositphotos.com/1570716/1697/i/950/depositphotos_16978587-stock-photo-male-chef-cooking.jpg" alt="">
<div>
    <a href="recipes.php">Par ici les recettes!</a>
</div>

<?php
include 'templates/footer.php';
?>
