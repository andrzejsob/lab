use lab;

create table session_variable (
    id int not null auto_increment primary key,
    sessionId int,
    name varchar(64),
    value text,
    foreign key (sessionId) references session(id)
);
