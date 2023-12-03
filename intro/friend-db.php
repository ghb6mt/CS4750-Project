<?php

function addFriends($name, $major, $year)
{
    global $db;

   // $query = "insert into friend values ('" . $name ."', '" . $major . "', '" . $year . "')";
    //$db->query($query) dont do this sice this can allow injection easy into sql

    $query = "insert into friend values (:name, :major, :year)"; //better way to put vars in

    //prepare: 
    // 1. prepare (compile) 
    // 2. bindValue + exe

    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':major', $major);
    $statement->bindValue(':year', $year);
    $statement->execute();

    $statement->closeCursor(); //do this to close connection to DB, save resources

}

function getAllFriends()
{
    global $db;

    $query = "select * from friend;";

   
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(); //fetch()
    $statement->closeCursor(); //do this to close connection to DB, save resources
    return $results;
}


function updateFriendByName($name, $major, $year){

    global $db;

    // $query = "insert into friend values ('" . $name ."', '" . $major . "', '" . $year . "')";
     //$db->query($query) dont do this sice this can allow injection easy into sql
 
     $query = "update friend set major=:major, year=:year where name=:name"; //better way to put vars in
 
     //prepare: 
     // 1. prepare (compile) 
     // 2. bindValue + exe
 
     $statement = $db->prepare($query);
     $statement->bindValue(':name', $name);
     $statement->bindValue(':major', $major);
     $statement->bindValue(':year', $year);
     $statement->execute();
 
     $statement->closeCursor(); //do this to close connection to DB, save resources

}

function deleteFriend($name){

    global $db;

    // $query = "insert into friend values ('" . $name ."', '" . $major . "', '" . $year . "')";
     //$db->query($query) dont do this sice this can allow injection easy into sql
 
     $query = "delete from friend where name=:name"; //better way to put vars in
 
     //prepare: 
     // 1. prepare (compile) 
     // 2. bindValue + exe
 
     $statement = $db->prepare($query);
     $statement->bindValue(':name', $name);
     $statement->execute();
 
     $statement->closeCursor(); //do this to close connection to DB, save resources

}

?>