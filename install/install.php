<?php
shell_exec("cp ./scoreboard-cc/install/cities.json ./");
$cities = json_decode(file_get_contents("./cities.json"));
//shell_exec("git clone https://github.com/muchomucho/scoreboard-cc.git");
$compose = "apache:\n    image: php:apache\n    volumes:\n    - /home/roussg/scoreboard/toulouse/src:/var/www/html\n    links:\n    - mysql\n    ports:\n    - 8881:80\n    privileged: true\n\nmysql:\n    image: mysql:latest\n    environment:\n         MYSQL_ROOT_PASSWORD: passroot\n";
$port = 8881;
foreach ($cities as $city)
{
    echo "STARTING CONTAINER " . $city . "\n"; // start creating container for 1 city
    shell_exec("mkdir " . $city); // create city directory
    chdir($city); // move to cit directory
    //shell_exec("cp ../scoreboard-cc/install/bdd_setup.sh ./"); // copy install files
    file_put_contents("docker-compose.yml", str_replace("8881", $port, str_replace("toulouse", $city, $compose))); // dcoker-compose.yml file
    echo shell_exec("ln -s ../scoreboard-cc/scoreboard ./src");
    echo shell_exec("docker-compose up -d"); //run docker compose as deamon
    
    echo shell_exec("docker cp ../scoreboard-cc/scoreboard/db.sql " . $city . "_mysql_1:/db.sql");

    echo shell_exec("docker exec -it " . $city . "_apache_1 /bin/bash -c 'docker-php-ext-install pdo pdo_mysql'"); //install pdo docker-php-ext-install pdo pdo_mysql
    echo shell_exec("docker restart " . $city . "_apache_1");


    chdir(".."); // return to root directory
    echo shell_exec("docker exec -it " . $city . "_mysql_1 /bin/bash  -c \"echo -e 'create database scoreboard;\nuse scoreboard\nsource /db.sql;INSERT INTO 'admin' ('id', 'mail', 'password', 'type') VALUES (NULL, '" . $city . "@epitech.eu', SHA1('admin" . $city . "'), 1);' | mysql -u root -ppassroot\""); // input bdd into mysql container
    echo "\n\n----------------------------------------------------------------------\n\n"; // end of script for 1 city
    $port++;
}
?>