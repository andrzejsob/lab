use lab;

create table user_role (
    userId int not null,
    roleId int unsigned not null,
    foreign key (userId) references user(id),
    foreign key (roleId) references role(id),
    unique (userId, roleId)
);
