use lab;

create table session (
    id int not null auto_increment primary key,
    session_ascii_id varchar(32),
    logged_in boolean,
    user_id int,
    last_reaction timestamp not null default current_timestamp
        on update current_timestamp,
    created timestamp not null,
    user_agent varchar(64),
    foreign key (user_id) references user(id)
);
