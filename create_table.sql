DROP TABLE IF EXISTS pmw_branduser;

CREATE TABLE pmw_branduser
(
	id             int not null primary key,
    username       char(16) not null,
    password       char(40) not null,
    brandid        int not null
);