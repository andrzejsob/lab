use lab;

create table contact_person (
    id int not null auto_increment primary key,
    client_id int,
    first_name varchar(32),
    last_name varchar(32),
    email varchar(64),
    email2 varchar(64),
    phone int(9),
    foreign key (client_id) references client(id)
);
