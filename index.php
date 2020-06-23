<?php

/**
 *Plugin Name: GITSALAH CONTACT FORM
 *Description: A contact form Made by GITSALAH
 */



//CALLING CONNECTION FROM WPCONFIG
require_once(ABSPATH . 'wp-config.php');
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysqli_select_db($connection, DB_NAME);

//CREATING NEW TABLE 
function createTable()
{
    global $connection;
    $sql = "CREATE TABLE posts(id int NOT NULL PRIMARY KEY AUTO_INCREMENT, Nom varchar(255) NOT NULL, objet varchar(255) NOT NULL, email varchar(255) NOT NULL, message varchar(255) NOT NULL)";
    $result = mysqli_query($connection, $sql);
    return $result;
}
//insert data to table 
function insertData($nom, $email, $objet, $message)
{
    global $connection;
    $sql = "INSERT INTO posts(Nom, email, objet, message) VALUES ('$nom', '$email', '$objet', '$message')";
    $result = mysqli_query($connection, $sql);
    return $result;
}

// checking if there is table 
function checkIfThereIsTable()
{
    global $connection;
    $sql = "SELECT * FROM posts";
    $result = mysqli_query($connection, $sql);
    return $result;
}

if (checkIfThereIsTable() == false) {
    createTable();
}


//creating new shortcode 
function contact($atts)
{

    extract(shortcode_atts(
        array(
            'name' => 'true',
            'email' => 'true',
            'objet' => 'true',
            'text' => 'true'

        ),
        $atts
    ));

    if ($name == "true") {
        $name1 = '<label>NAME:</label><input type="text" required name="nom">';
    } else {
        $name1 = "";
    }

    if ($email == "true") {
        $email1 = '<label>EMAIL:</label><input type="email" required name="email">';
    } else {
        $email1 = "";
    }

    if ($objet == "true") {
        $objet1 = '<label>Object:</label><input type="text" required name="objet">';
    } else {
        $objet1 = "";
    }

    if ($text == "true") {
        $text1 = '<label>Message:</label><textarea type="text" required name="text"></textarea>';
    } else {
        $text1 = "";
    }



    echo '<form method="POST"  >' . $name1 . $email1 . $objet1 .  $text1 . '<input style="margin-top:10px" value="Submit" type="submit" name="submitcheck">
    </form>';
}
//call shortcode 
add_shortcode('gitform', 'contact');

//push data to DATABASE
if (isset($_POST['submitcheck'])) {

    $name = $_POST['nom'];
    $email = $_POST['email'];
    $objet = $_POST['objet'];
    $text = $_POST['text'];

    insertData($name, $email, $objet, $text);
}



//SHOWING IN DASHBOARD
add_action("admin_menu", "addMenu");
function addMenu()
{
    add_menu_page("gitform", "gitform", 4, "gitform", "documentation", "https://res.cloudinary.com/dzjzhwh7o/image/upload/v1592950143/git_rpe9zx.svg");
}


//doc 
function documentation()
{
    echo <<< 'EOD'
    <div style="background-image: url(https://res.cloudinary.com/dzjzhwh7o/image/upload/v1592946925/1_uxutwu.jpg);background-size: contain;width: 1359px;height: 1360px;position: relative;right: 20px;bottom: 17px;">
        <div style="display: flex;
        justify-content: center;
        position: relative;
        top: 132px;
        width:100%">
        <img style="width: 3%;
        margin-right: 12px;" src="https://res.cloudinary.com/dzjzhwh7o/image/upload/v1592946925/git_lh3ryt.png" alt="">
       <img style="width: 33%;" src="https://fontmeme.com/permalink/200623/07d6c3284fd5b4965bc607def8e18c8f.png" alt="github-font" border="0">
    </div>
        <div style="display: flex; justify-content:center;align-items:center;margin-top:20%;">
            <div>
                <ul style="color: white; font-family:poppins;list-style: disc;">
                    <p style="text-align: center;">To add a new contact form add this shortcode <b>[gitform]</b><br> else if you want delete
                        something you can use :</p>
                    <li>for deleting name : <b>[gitform name=false] </b></li>
                    <li>for deleting email : <b>[gitform email=false] </b> </li>
                    <li>for deleting object : <b>[gitform objet=false]</b></li>
                    <li>for deleting message : <b>[gitform text=false]</b> </li>

                </ul>
            </div>
        </div>
    </div>
EOD;
}
