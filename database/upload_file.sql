create table upload_file(
file_id varchar(255) not null primary key,
name_ori varchar(255),
name_save varchar(255),
reg_time timestamp not null
) default character set utf8 collate utf8_general_ci;