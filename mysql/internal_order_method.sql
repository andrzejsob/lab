use lab;

create table internal_order_method (
    internal_order_id int not null,
    method_id int not null,
    foreign key (internal_order_id) references internal_order(id),
    foreign key (method_id) references method(id),
    unique (internal_order_id, method_id)
);
