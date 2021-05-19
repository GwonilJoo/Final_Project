create table save_weight(
user_id varchar(255) not null,
dataset varchar(255) not null,
save_name varchar(255),
model varchar(255),
primary key(user_id, dataset, save_name)
) default character set utf8 collate utf8_general_ci;