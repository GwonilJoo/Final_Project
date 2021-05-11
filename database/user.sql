create table user(
id varchar(255) not null primary key,
passwd varchar(255) not null,
email varchar(255) not null
) default character set utf8 collate utf8_general_ci;