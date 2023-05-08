select user, host from mysql.user;

create user 'hrishi'@'localhost' identified by 'password';

grant all privileges on * . * to 'hrishi'@'localhost';

flush privileges;

create database larajobs;

use larajobs;

show tables;

select * from users;

select * from listings;