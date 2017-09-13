use lab;

create table permission (
    id int unsigned not null auto_increment primary key,
    name varchar(64),
    description varchar(128)
);
