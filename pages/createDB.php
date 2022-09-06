<?php
    $categories = "create table categories
(
    id int not null AUTO_INCREMENT primary key,
    category varchar(60) not null unique 
);";

    $subCategories = "create table sub_categories
(
    id int not null AUTO_INCREMENT primary key,
    cat_id int,
    foreign key (cat_id) references categories(id) on update cascade,
    sub_category varchar(64) not null unique 
);";

    $items = "create table items(
    id int no null AUTO_INCREMENT primary key,
    item_name varchar(50) not null unique,
    cat_id int,
    foreign key (cat_id) references categories(id) on update cascade,
    price_in int not null,
    price_sale int no null,
    info varchar(256) not null,
    rate double,
    image_path varchar(256) not null,
    action int
);";

    $image = "create table image(
    id int not null AUTO_INCREMENT primary key,
    image_path varchar(255) not null unique,
    item_id int,
    foreign key (item_id) references items(id) on delete cascade 
);";

    $roles = "create table roles(
    id int not null AUTO_INCREMENT primary key,
    role varchar(32) not null unique 
);";

    $customer = "create table roles(
    id int not null AUTO_INCREMENT primary key,
    login varchar(32) not null unique,
    pass varchar(128) not null,
    role_id int,
    foreign key(role_id) references roles(id) on update cascade,
    discount int,
    total int,
    image_path varchar(255)   
);";





























