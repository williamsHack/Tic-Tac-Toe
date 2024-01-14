<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $moves = $_POST["moves"]; // Store the game progress/moves as needed
    $game_result = $_POST["result"]; // Assuming "result" is sent by the client (e.g., "win", "lose", "draw")

    $sql = "INSERT INTO game_progress (user_id, moves, games_played) VALUES ($user_id, '$moves', 1)
            ON DUPLICATE KEY UPDATE games_played = games_played + 1";

    if ($conn->query($sql)) {
        echo "Game progress stored successfully!";

        if ($game_result == "win") {
            $sql = "UPDATE game_progress SET games_won = games_won + 1 WHERE user_id = $user_id";
        } elseif ($game_result == "lose") {
            $sql = "UPDATE game_progress SET games_lost = games_lost + 1 WHERE user_id = $user_id";
        }

        $conn->query($sql);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>