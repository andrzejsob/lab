use lab;

create table role_perm (
    roleId int unsigned not null,
    permId int unsigned not null,
    foreign key (roleId) references role(id),
    foreign key (permId) references permission(id),
    unique (roleId, permId)
);
