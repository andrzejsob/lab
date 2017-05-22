use lab;

create table client (
    id int not null auto_increment primary key,
    name varchar(64),
    street varchar(64),
    zip_code varchar(8),
    city varchar(64),
    nip varchar(13)
);
