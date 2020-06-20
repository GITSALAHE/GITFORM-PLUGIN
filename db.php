<?php

class Contact extends DB
{
  public function gitform($nom, $email, $objet, $message)
  {

    $sql = "INSERT INTO `Posts`(`Nom`, `email`, `objet`, `message`) VALUES ('$nom', '$email', '$objet', '$message')";
    $result = $this->connect()->query($sql);
    return $result;
  }
}
