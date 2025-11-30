<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo "<div class='flex bg-gray-800 p-3 text-white justify-between sticky top-0 z-10'>
    <div>
    ";

    $hour = date("G");

    if($hour > 0 && $hour < 24){
        if($hour >= 3 && $hour < 12)
        {
            echo "<p>Good Morning, ".$_SESSION['username']."</p>";
        }else if($hour >= 12 && $hour < 17){
            echo "<p>Good afternoon, ".$_SESSION['username']."</p>";
        }else{
            echo "<p>Good evening, ".$_SESSION['username']."</p>";
        }
    }
    else {
        echo "<p>Greetings, ".$_SESSION['username']."</p>";
    }

    echo "</div>
        <div>
            <h3>MovieFinder Admin</h3>
        </div>
        <div class='flex gap-6'>
            <a href='dashboard.php'>Dashboard</a>
            <a href='add-movie.php'>New Film</a>
            <a href='logout.php?redirect=".$_SERVER["REQUEST_URI"]."'>Logout</a>
        </div>
    </div>";

}
?>