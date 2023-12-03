
<link href="NiceAdmin/assets/css/style.css" rel="stylesheet">
<?php

require("connect-db.php");

function addMovie($title, $runtime, $year, $desc, $age, $genre, $lead){
    global $db;

    $desc = $db->quote($desc); //prepares string for insert

    $midquery = "SELECT MAX(movie_id) as movie_id FROM movies"; //do this to get next ID
    $midstatement = $db->prepare($midquery);
    $midstatement->execute();
    $mid = $midstatement->fetch();
    $mid = $mid['movie_id'] + 1;
    $midstatement->closeCursor();


    $query = "INSERT INTO movies VALUES (:mid, :title, :runtime, :year, :desc, :age);
    INSERT INTO genres VALUES (:mid, :genre);
    INSERT INTO lead_actors VALUES (:mid, :lead);
    ";

$statement = $db->prepare($query);
$statement->bindValue(':title', $title);
$statement->bindValue(':runtime', $runtime);
$statement->bindValue(':year', $year);
$statement->bindValue(':desc', $desc);
$statement->bindValue(':age', $age);
$statement->bindValue(':genre', $genre);
$statement->bindValue(':lead', $lead);
$statement->bindValue(':mid', $mid);

$statement->execute();

$statement->closeCursor();

}

function deleteMovie($mid){
    global $db;
    $query = " DELETE FROM rating WHERE movie_id = :mid;
    DELETE FROM snacks WHERE movie_id = :mid;
    DELETE FROM theater_to_movie WHERE movie_id = :mid;
    DELETE FROM showing_info WHERE movie_id = :mid;
    DELETE FROM favorites WHERE movie_id = :mid;
    DELETE FROM genres WHERE movie_id = :mid;
    DELETE FROM lead_actors WHERE movie_id = :mid;
    DELETE FROM movies WHERE movie_id = :mid;";

    $statement = $db->prepare($query);
    $statement->bindValue(':mid', $mid);

    $statement->execute();

    $statement->closeCursor(); //do this to close connection to DB, save resources


}

function updateMovie($attr, $val, $mid){
    global $db;
    $val = $db->quote($val);
    $query = "UPDATE movies SET $attr = \'$val\' WHERE movie_id = :mid;";
    $statement = $db->prepare($query);
    $statement->bindValue(':mid', $mid);

    $statement->execute();

    $statement->closeCursor(); //do this to close connection to DB, save resources

}

function updateMovieGenre($val, $mid){
    global $db;
    $query = "UPDATE genres SET genre = \"$val\" WHERE movie_id = :mid";
    $statement = $db->prepare($query);
    //$statement->bindValue(':val', $val);
    $statement->bindValue(':mid', $mid);

    $statement->execute();

    $statement->closeCursor(); //do this to close connection to DB, save resources
}

function updateMovieLeadActor($val, $mid){
    global $db;
    $query = "UPDATE lead_actors SET lead_actor = \"$val\" WHERE movie_id = :mid;";
    $statement = $db->prepare($query);
    //$statement->bindValue(':val', $val);
    $statement->bindValue(':mid', $mid);

    $statement->execute();

    $statement->closeCursor(); //do this to close connection to DB, save resources
}

//Need to be admin to use this
function addMovieShowing($mid, $tid, $time, $room){

    global $db;

    $sidquery = "select max(showing_id) as showing_id from showing_info"; //do this to get next ID
    $sidstatement = $db->prepare($sidquery);
    $sidstatement->execute();
    $sid = $sidstatement->fetch();
    $sid = $sid['showing_id'] + 1;
    $sidstatement->closeCursor();
    

    $query = "INSERT INTO showing_info VALUES (:sid, :mid, :tid, :time, :room);
    INSERT INTO theater_to_movie VALUES (:tid, :time, :room, :sid, :mid)";
    $statement = $db->prepare($query);
    $statement->bindValue(':tid', $tid);
    $statement->bindValue(':mid', $mid);
    $statement->bindValue(':time', $time);
    $statement->bindValue(':room', $room);
    $statement->bindValue(':sid', $sid);


    $statement->execute();
    $statement->closeCursor(); //do this to close connection to DB, save resources
}

//Only Admin Allowed
function deleteMovieShowing($sid){
    global $db;
    $query = "DELETE FROM theater_to_movie WHERE showing_id = :sid;
    DELETE FROM showing_info WHERE showing_id = :sid";
    $statement = $db->prepare($query);
    $statement->bindValue(':sid', $sid);

    $statement->execute();

    $statement->closeCursor(); //do this to close connection to DB, save resources
}


//Only Admin Allowed
function updateMovieShowing($attr, $val, $sid){
    try{
    global $db;
    $query = "UPDATE showing_info SET $attr = :val WHERE showing_id = :sid;";
    $statement = $db->prepare($query);
    $statement->bindValue(':sid', $sid);
    // $statement->bindValue(':attr', $attr);
    $statement->bindValue(':val', $val);

    $statement->execute();

    $statement->closeCursor(); //do this to close connection to DB, save resources
    }
    catch (PDOException $e) {
        // Catch any database exceptions and display the error on your webpage
        echo "Database Error: " . $e->getMessage();
    }
}

//Only Admin Allowed
function addTheater($city, $street, $state, $company, $zip){
    global $db;

    $tidquery = "select max(theater_id) as theater_id from theaters"; //do this to get next ID
    $tidstatement = $db->prepare($tidquery);
    $tidstatement->execute();
    $tid = $tidstatement->fetch();
    $tid = $tid['theater_id'] + 1;
    $tidstatement->closeCursor();


    $query = "INSERT INTO theaters VALUES (:tid, :city, :street, :state);
    INSERT INTO theater_company VALUES (:tid, :company);
    INSERT INTO zip_codes VALUES (:city, :street, :state, :zip);";
    $statement = $db->prepare($query);
    $statement->bindValue(':tid', $tid);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':street', $street);
    $statement->bindValue(':state', $state);
    $statement->bindValue(':company', $company);
    $statement->bindValue(':zip', $zip);

    $statement->execute();

    $statement->closeCursor(); //do this to close connection to DB, save resources
}

//Only Admin Allowed
function addSnack($mid, $name, $price, $brand, $type, $cals){
    global $db;


    $query = "INSERT INTO snacks VALUES (NULL, :mid, :name, :price, :brand);
    INSERT INTO snack_info VALUES (:name, :price, :brand, :type, :cals);";
    $statement = $db->prepare($query);
    $statement->bindValue(':mid', $mid);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':brand', $brand);
    $statement->bindValue(':type', $type);
    $statement->bindValue(':cals', $cals);

    $statement->execute();

    $statement->closeCursor(); //do this to close connection to DB, save resources

}

function getSnacksForMovie($mid){
    global $db;

    $query = "SELECT * from snacks where movie_id = :mid";
    $statement = $db->prepare($query);
    $statement->bindValue(':mid', $mid);

    $statement->execute();
    $snacks = $statement->fetchAll();
    $statement->closeCursor(); //do this to close connection to DB, save resources
    return $snacks;
}

function rateMovie($username, $mid, $stars, $review){
    global $db;
    $review = $db->quote($review);
    $query = "INSERT INTO rating VALUES (NULL, :username, :mid, :stars, :review);";
    $statement = $db->prepare($query);
    $statement->bindValue(':mid', $mid);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':stars', $stars);
    $statement->bindValue(':review', $review);

    $statement->execute();

    $statement->closeCursor();
}

function favoriteMovie($username, $mid){
    global $db;

    $query = "INSERT INTO favorites VALUES (:username, :mid);";
    $statement = $db->prepare($query);
    $statement->bindValue(':mid', $mid);
    $statement->bindValue(':username', $username);
    
    $statement->execute();

    $statement->closeCursor();
    
}

function removeFavorite($username, $mid){
    global $db;

    $query = "DELETE FROM favorites WHERE movie_id = :mid and username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':mid', $mid);
    $statement->bindValue(':username', $username);
    
    $statement->execute();

    $statement->closeCursor();
}

function createUser($username, $first, $last, $pass, $email, $phone){
    global $db;

    $query = "INSERT INTO account VALUES (:username, :first, :last, :pass, '0');
    INSERT INTO email_addresses VALUES (:username, :email);
    INSERT INTO phone_numbers VALUES (:username, :phone);
    ";
    $statement = $db->prepare($query);
    $statement->bindValue(':first', $first);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':last', $last);
    $statement->bindValue(':pass', $pass);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    
    $statement->execute();

    $statement->closeCursor();

}

function createAdmin($username, $first, $last, $pass, $email, $phone){
    global $db;

    $query = "INSERT INTO account VALUES (:username, :first, :last, :pass, '1');
    INSERT INTO email_addresses VALUES (:username, :email);
    INSERT INTO phone_numbers VALUES (:username, :phone);
    ";
    $statement = $db->prepare($query);
    $statement->bindValue(':first', $first);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':last', $last);
    $statement->bindValue(':pass', $pass);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    
    $statement->execute();

    $statement->closeCursor();

}


function deleteUser($username){
    global $db;
    $user = "'".$username."'";
    $query = "DELETE FROM `phone_numbers` WHERE username = $user;
    DELETE FROM `email_addresses` WHERE username = $user;
    DELETE FROM `account` WHERE username = $user;";
    $statement = $db->prepare($query);
   // $statement->bindValue(':username', $user);
    $statement->execute();

    $statement->closeCursor();
    
}
function deleteTheater($tid){
    global $db;

    $query = "DELETE FROM theater_to_movie WHERE theater_id = :tid;
            DELETE FROM theater_company WHERE theater_id = :tid;
            DELETE FROM showing_info WHERE theater_id = :tid;
            DELETE FROM theaters WHERE theater_id = :tid;";
    $statement = $db->prepare($query);
    $statement->bindValue(':tid', $tid);
    $statement->execute();

    $statement->closeCursor();
}

function getUserInfo($username){
    global $db;

    $query = "SELECT * FROM account WHERE username = “:username”;";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();

    $userinfo = $statement->fetchAll();

    $statement->closeCursor();

    return $userinfo;
}

function updateUserInfo($username,$attr, $val){

    global $db;

    $query = "UPDATE account SET :attr = :val WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':attr', $attr);
    $statement->bindValue(':val', $val);
    $statement->execute();

    $statement->closeCursor();

}


function getAllMovieInfo(){
    global $db;

    $query = "SELECT title, year, runtime, age_rating FROM movies;";
    $statement = $db->prepare($query);

    $statement->execute();
    $movies = $statement->fetchAll();

    $statement->closeCursor();

    return $movies;
}

function getMovieInfo($mid){
    global $db;

    $query = "SELECT * FROM movies NATURAL JOIN lead_actors WHERE movie_id = :mid;";
    $statement = $db->prepare($query);
    $statement->bindValue(':mid', $mid);
    $statement->execute();
    $movies = $statement->fetchAll();

    $statement->closeCursor();

    return $movies;
}
function getMoviesAtTheater($theaterId){
    global $db;

    $query = "SELECT title, year, runtime, age_rating FROM movies NATURAL JOIN showing_info WHERE theatre_id = :theaterId";
    $statement = $db->prepare($query);
    $statement->bindValue(':theaterId', $theaterId);

    $statement->execute();
    $movies = $statement->fetchAll();
    $statement->closeCursor();

    return $movies;
}

function getMovieShowings($theaterId, $timeStart, $timeEnd){
    global $db;

    $query = "SELECT showing_info.* FROM showing_info WHERE theater_id = :theaterId AND time BETWEEN :timeStart AND :timeEnd";
    $statement = $db->prepare($query);
    $statement->bindValue(':theaterId', $theaterId);
    $statement->bindValue(':timeStart', $timeStart);
    $statement->bindValue(':timeEnd', $timeEnd);

    $statement->execute();
    $showings = $statement->fetchAll();
    $statement->closeCursor();

    return $showings;
}

function getAverageRating($movieId){
    global $db;

    $query = "SELECT movie_id, year, AVG(number_of_stars) AS average_rating FROM rating WHERE movie_id = :movieId GROUP BY movie_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':movieId', $movieId);

    $statement->execute();
    $rating = $statement->fetchAll();
    $statement->closeCursor();

    return $rating;
}

function searchByTitle($title){
    global $db;

    $query = "SELECT title, year FROM movies WHERE title LIKE :title";
    $statement = $db->prepare($query);
    $title = '%' . $title . '%';
    $statement->bindValue(':title', $title);

    $statement->execute();
    $movies = $statement->fetchAll();
    $statement->closeCursor();

    return $movies;
}

function searchByGenre($genre){
    global $db;

    $query = "SELECT title, year FROM genres NATURAL JOIN movies WHERE genre = :genre";
    $statement = $db->prepare($query);
    $statement->bindValue(':genre', $genre);

    $statement->execute();
    $movies = $statement->fetchAll();
    $statement->closeCursor();

    return $movies;
}

function searchByLeadActor($actor){
    global $db;

    $query = "SELECT title, year FROM lead_actors NATURAL JOIN movies WHERE lead_actor = :actor";
    $statement = $db->prepare($query);
    $statement->bindValue(':actor', $actor);

    $statement->execute();
    $movies = $statement->fetchAll();
    $statement->closeCursor();

    return $movies;
}

function searchByRating($rating){
    global $db;

    $query = "SELECT title, year FROM movies NATURAL JOIN rating WHERE AVG(number_of_stars) = :rating";
    $statement = $db->prepare($query);
    $statement->bindValue(':rating', $rating);

    $statement->execute();
    $movies = $statement->fetchAll();
    $statement->closeCursor();

    return $movies;
}

function searchByRuntime($runtime){
    global $db;

    $query = "SELECT title, year FROM movies WHERE runtime <= :runtime";
    $statement = $db->prepare($query);
    $statement->bindValue(':runtime', $runtime);

    $statement->execute();
    $movies = $statement->fetchAll();
    $statement->closeCursor();

    return $movies;
}

function getAverageRatingForMovie($movieId){
    global $db;

    $query = "CALL calc_avg_rating(:movieId, @avg_rating)";
    $statement = $db->prepare($query);
    $statement->bindValue(':movieId', $movieId);

    $statement->execute();

    $result = $statement->fetch();
    $statement->closeCursor();

    return $result;
}

function login($username, $password){
    global $db;

    $query = 'SELECT * FROM account WHERE username = :username AND password = :password';

    $statement = $db->prepare($query);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':username', $username);

    $statement->execute();

    $result = $statement->fetchAll(); // Returns PDO
    
    if(count($result)  > 1){
        echo "<p>Error on login.</p>";
        return -1;
    } elseif(count($result) < 1){
        echo "<p>Username or password incorrect.</p>";
        return -2;
    }
    
    $_SESSION['username'] = $result['username'];
    $_SESSION['is_admin'] = $result['is_admin'];
    $statement->closeCursor();

    return true;
}

function getMovieGenre($mid){
    global $db;

    $query = "SELECT genre FROM genres WHERE movie_id = :mid;";
    $statement = $db->prepare($query);
    $statement->bindValue(':mid', $mid);
    $statement->execute();
    $movies = $statement->fetchAll();

    $statement->closeCursor();

    return $movies;
}

function getMovieLeadActor($mid){
    global $db;

    $query = "SELECT lead_actor FROM lead_actors WHERE movie_id = :mid;";
    $statement = $db->prepare($query);
    $statement->bindValue(':mid', $mid);
    $statement->execute();
    $movies = $statement->fetchAll();

    $statement->closeCursor();

    return $movies;
}

function allMovies(){
    global $db;

    $query = "SELECT * FROM movies;";
    $statement = $db->prepare($query);

    $statement->execute();
    $movies = $statement->fetchAll();

    $statement->closeCursor();

    return $movies;
}

function getAllTheaters(){
    global $db;

    $query = "SELECT * FROM theaters;";
    $statement = $db->prepare($query);

    $statement->execute();
    $theaters = $statement->fetchAll();

    $statement->closeCursor();

    return $theaters;

}

function getTheaterCompany($tid){
    global $db;

    $query = "SELECT company FROM theater_company where :tid = theater_id;";
    $statement = $db->prepare($query);
    $statement->bindValue(':tid', $tid);

    $statement->execute();
    $theaters = $statement->fetchAll();

    $statement->closeCursor();

    return $theaters;
}

function getAllShowings(){
    global $db;

    $query = "SELECT * FROM showing_info";
    $statement = $db->prepare($query);

    $statement->execute();
    $showings = $statement->fetchAll();

    $statement->closeCursor();

    return $showings;
    
}

function getTheater($tid){
    global $db;

    $query = "SELECT * FROM theaters where theater_id = :tid";
    $statement = $db->prepare($query);
    $statement->bindValue(':tid', $tid);

    $statement->execute();
    $theater = $statement->fetchAll();

    $statement->closeCursor();

    return $theater;
}

function getAllSnacks(){
    global $db;

    $query = "SELECT * FROM snacks NATURAL JOIN snack_info";
    $statement = $db->prepare($query);

    $statement->execute();
    $snacks = $statement->fetchAll();

    $statement->closeCursor();

    return $snacks;
}

function getSpecificMovieShowings($movieID) {
    global $db;

    $query = "SELECT * FROM showing_info WHERE movie_id = :movieID AND time > CURRENT_TIMESTAMP";
    $statement = $db->prepare($query);
    $statement->bindValue(':movieID', $movieID);

    $statement->execute();
    $showings = $statement->fetchAll();
    $statement->closeCursor();

    return $showings;
}

function getZipCode($city, $street, $state) {
    global $db;

    $query = "SELECT zip_code FROM zip_codes WHERE city = :city AND street = :street AND state = :state";
    $statement = $db->prepare($query);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':street', $street);
    $statement->bindValue(':state', $state);
    $statement->execute();
    $zc = $statement->fetchAll();
    $statement->closeCursor();

    return $zc;
}

function getSingleShowing($sid) {
    global $db;

    $query = "SELECT * FROM showing_info where showing_id = :sid";
    $statement = $db->prepare($query);
    $statement->bindValue(':sid', $sid);
    $statement->execute();
    $showing = $statement->fetchAll();
    $statement->closeCursor();

    return $showing;
}

function getSnack($sid){
    global $db;

    $query = "SELECT * FROM snacks Natural Join snack_info where snack_id = :sid";
    $statement = $db->prepare($query);
    $statement->bindValue(':sid', $sid);
    $statement->execute();
    $snack = $statement->fetchAll();
    $statement->closeCursor();

    return $snack;
}

function updateSnackInfo($attr, $val, $name){
    global $db;

    $query = "UPDATE snacks_info SET $attr = \'$val\' WHERE name = :name;";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->execute();
    $snack = $statement->fetchAll();
    $statement->closeCursor();

    return $snack;
}

function deleteSnack($sid, $name, $price, $brand){

    global $db;

    $query = "DELETE FROM snack_info WHERE name = :name and price = :price and brand = :brand;
    DELETE FROM snacks WHERE snack_id = :sid;";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':brand', $brand);
    $statement->bindValue(':sid', $sid);
    $statement->execute();
    $statement->closeCursor();
    
}

function getAllUsers($username){
    global $db;

    $query = "SELECT username, is_admin FROM account where username <> :username ";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();

    return $users;
}


function getUserAdmin($uname){
    global $db;

    $query = "SELECT is_admin FROM account where username = :username ";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $uname);
    $statement->execute();
    $user = $statement->fetch();
    $user = $user['is_admin'];
    $statement->closeCursor();

    return $user;
}


function swapUserRole($username, $admin){
    global $db;
    if($admin == 0){
        $newrole = 1;
    }
    else{
        $newrole = 0;
    }

    $query = "UPDATE account SET is_admin = :admin where username = :username;";
    $statement = $db->prepare($query);
    $statement->bindValue(':admin', $newrole);
    $statement->bindValue(':username', $username);

    $statement->execute();

    $statement->closeCursor(); //do this to close connection to DB, save resources
}

function getAllUsernames(){
    global $db;

    $query = "SELECT username FROM account";
    $statement = $db->prepare($query);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();

    return $users;
}

function hasUserRated($username, $mid){
    global $db;
    $username = "'". $username . "'";
    $query = "SELECT username, movie_id FROM rating where username = $username and movie_id = $mid";
    $statement = $db->prepare($query);
    $statement->execute();
    $ratings = $statement->fetchAll();
    $statement->closeCursor();

    return $ratings;
}