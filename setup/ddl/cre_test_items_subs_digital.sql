drop table if exists test_items_subs_digital;

create table if not exists test_items_subs_digital
(system_type varchar(80),
 provider    varchar(80),
 month_fee   float
 )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

insert into test_items_subs_digital
(system_type, provider, month_fee)
values
('SUBS_DIGITAL','Netflix',4.99);

insert into test_items_subs_digital
(system_type, provider, month_fee)
values
('SUBS_DIGITAL','Amazon Video',6.99);

insert into test_items_subs_digital
(system_type, provider, month_fee)
values
('SUBS_DIGITAL','All4',4.99);

insert into test_items_subs_digital
(system_type, provider, month_fee)
values
('SUBS_DIGITAL','Apple TV',8);

