<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Add your Tic Tac Toe game logic here

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 id="heading">Play</h1>
    <a href="logout.php">
    <button style="float:right; margin:2%;" class="btn btn-default mode-button">Logout</button></a>
        <div id="mode-buttons">
            <button class="mode-button" id="twoPlayersMode">Two Players</button>
            <button class="mode-button" id="vsAIMode">vs COMPUTER</button>
        </div>
        <button id="restart">Restart</button>
        <div id="board"></div>
        <div id="scores">Player: <span id="playerScore">0</span>, Computer: <span id="aiScore">0</span>, Tie: <span id="tieScore">0</span></div>
    </div>
    

    <!-- Add this section inside the <body> tag, before the <script> tag -->
    <audio id="backgroundMusic" loop>
        <source src="background-music.mp3" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>
    
    <audio id="clickSound">
        <source src="click-sound.mp3" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>
    
    <audio id="winSound">
        <source src="win-sound.mp3" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>
    
    <audio id="drawSound">
        <source src="draw-sound.mp3" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>

    <script src="script.js"></script>
</body>
</html>
