<?php

/**
 *Plugin Name: GITSALAH CONTACT FORM
 *Description: A contact form Made by GITSALAH
 */




include('connect.php');
include('db.php');
$data = new Contact();
$errors = array();
function newDb(){
    $link = mysqli_connect("localhost", "root", "");
    $sql = "CREATE DATABASE gitform";
    $result = mysqli_query($link, $sql);
    return $result;
}
function newTable(){
    $link = mysqli_connect("localhost", "root", "", "gitform");
    $sql = "CREATE TABLE Posts(id int NOT NULL PRIMARY KEY AUTO_INCREMENT, Nom varchar(255) NOT NULL, objet varchar(255) NOT NULL, email varchar(255) NOT NULL, message varchar(255) NOT NULL)";
    $result = mysqli_query($link, $sql);
    return $result;
}
if (mysqli_connect("localhost", "root", "", "gitform") === false) {
    newDb();
    newTable();
}





function contact()
{
    $html = '';
    // $html .= ;
    $html .= '<h2>Contact us</h2>';
    $html .= '<form method="post" action=".">';
    $html .= '<label>Name</label>';
    $html .=  '<input type="text" name="Nom" class="form-group" placeholder="type your name"';
    $html .= '<label>Email</label>';
    $html .=  '<input type="email" name="email" class="form-group" placeholder="type your email"';
    $html .= '<label>Object</label>';
    $html .=  '<input type="text" name="objet" class="form-group" placeholder="type your object"';
    $html .= '<label>Your message</label>';
    $html .=  '<textarea name="message"></textarea>';
    $html .= '<input type="submit" name="savegit" class="btn btn-primary">';
    $html .= '</form>';
    return $html;
}
if (isset($_POST['savegit'])) {
    $errors = validateContact($_POST);
    if (count($errors) === 0) {
        $name = $_POST['Nom'];
        $email = $_POST['email'];
        $objet = $_POST['objet'];
        $message = $_POST['message'];

        $push = $data->gitform($name, $email, $objet, $message);
    }
}

function validateContact($user)
{
    $errors = array();
    if (empty($user['Nom'])) {
        array_push($errors, 'Name is required');
    }

    if (empty($user['email'])) {
        array_push($errors, 'password is required');
    }
    if (empty($user['objet'])) {
        array_push($errors, 'password is required');
    }
    if (empty($user['message'])) {
        array_push($errors, 'password is required');
    }

    return $errors;
}
add_shortcode('gitform', 'contact');
