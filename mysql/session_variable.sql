use lab;

create table session_variable (
    id int not null auto_increment primary key,
    session_id int,
    name varchar(64),
    value text,
    foreign key (session_id) references session(id)
);
