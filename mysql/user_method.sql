use lab;

create table user_method (
    user_id int not null,
    method_id int not null,
    foreign key (user_id) references user(id),
    foreign key (method_id) references method(id),
    unique (user_id, method_id)
);
