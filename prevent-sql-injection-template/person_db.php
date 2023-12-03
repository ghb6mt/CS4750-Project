<?php

// CREATE TABLE person (
// 		name varchar(30) NOT NULL,
//      email varchar(30) NOT NULL,
// 		PRIMARY KEY (name) );

// CREATE TABLE private (
// 		id int NOT NULL,
// 		secrets varchar(255) NOT NULL,
// 		PRIMARY KEY (id) );

// INSERT INTO person (name, email) VALUES ("someone", "someone@uva.edu");
// INSERT INTO person (name, email) VALUES ("someone else", "someone_else@uva.edu");
// INSERT INTO person (name, email) VALUES ("wacky", "wacky@uva.edu");
// INSERT INTO person (name, email) VALUES ("duh", "duh@uva.edu");

// INSERT INTO private (id, secrets) VALUES (1, "You shouldn't see this");
// INSERT INTO private (id, secrets) VALUES (2, "Here is my secret");
// INSERT INTO private (id, secrets) VALUES (3, "I am a spy");
// INSERT INTO private (id, secrets) VALUES (4, "I plan to hack your account");


// Prepared statement (or parameterized statement) happens in 2 phases:
//   1. prepare() sends a template to the server, the server analyzes the syntax
//                and initialize the internal structure.
//   2. bind value (if applicable) and execute
//      bindValue() fills in the template (~fill in the blanks).
//                For example, bindValue(':name', $name);
//                the server will locate the missing part signified by a colon
//                (in this example, :name) in the template
//                and replaces it with the actual value from $name.
//                Thus, be sure to match the name; a mismatch is ignored.
//      execute() actually executes the SQL statement

function getPersonInfo($name)
{
	
	
	
	
	
}

