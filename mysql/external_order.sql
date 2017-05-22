use lab;

create table external_order (
    id int not null auto_increment primary key,
    contact_person_id int not null,
    nr int(3) not null,
    year year(4) not null,
    akr boolean not null,
    order_date date not null,
    nr_of_analyzes int not null,
    sum int,
    foreign key (contact_person_id) references contact_person(id)
);
