use lab;

create table user (
    id int not null auto_increment primary key,
    nick varchar(32) not null,
    password_md5 varchar(64) not null,
    first_name varchar(32) not null,
    last_name varchar(32) not null,
    email varchar(64) not null
);
