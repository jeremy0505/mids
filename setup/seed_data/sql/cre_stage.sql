use mids;

drop table if exists stage_room_types;
drop table if exists stage_categories;
drop table if exists stage_item_types;
drop table if exists stage_suggested_items;

CREATE TABLE IF NOT EXISTS stage_room_types (
  code VARCHAR(30) NOT NULL,
  name VARCHAR(80) NOT NULL,
  seq  int)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS stage_categories (
  name VARCHAR(30) NOT NULL,
  system_or_user VARCHAR(5) NOT NULL,
  system_type VARCHAR(30) NOT NULL,
  user_type VARCHAR(80) NULL,
  phys_or_digi VARCHAR(8) NOT NULL)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS stage_item_types (
  name VARCHAR(80) NOT NULL,
  code VARCHAR(30) NOT NULL,
  category VARCHAR(30) NOT NULL,
  dflt_room_code VARCHAR(80) NULL,
  include_in_wizard VARCHAR(1) NULL,
  optional_description VARCHAR(80) NULL,
  show_retailer VARCHAR(1) NULL,
  retailer_label VARCHAR(80) NULL,
  show_mfr VARCHAR(1) NULL,
  mfr_label VARCHAR(80) NULL,
  show_model_name VARCHAR(1) NULL,
  model_name_label VARCHAR(80) NULL,
  show_serial VARCHAR(1) NULL,
  serial_label VARCHAR(80) NULL,
  show_purch_date VARCHAR(1) NULL,
  purch_date_label VARCHAR(80) NULL,
  show_start_date VARCHAR(1) NULL,
  start_date_label VARCHAR(80) NULL,
  show_expiry_date VARCHAR(1) NULL,
  expiry_date_label VARCHAR(80) NULL,
  show_price_paid VARCHAR(1) NULL,
  price_paid_label VARCHAR(80) NULL,
  show_val_now VARCHAR(1) NULL,
  val_now_label VARCHAR(80) NULL,
  show_val_now_eff_date VARCHAR(1) NULL,
  val_now_eff_date_label VARCHAR(80) NULL,
  show_val_basis VARCHAR(1) NULL,
  val_basis_label VARCHAR(80) NULL,
  show_contact_phone VARCHAR(1) NULL,
  contact_phone_label VARCHAR(80) NULL)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS stage_suggested_items (
  name VARCHAR(80) NOT NULL,
  item_type_code VARCHAR(30) NOT NULL,
  relevant_country VARCHAR(10) NULL)
ENGINE = InnoDB;


LOAD DATA INFILE '~/code/mids/setup/seed_data/data/room_types.csv' 
INTO TABLE stage_room_types 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;


LOAD DATA INFILE '~/code/mids/setup/seed_data/data/categories.csv' 
INTO TABLE stage_categories 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE '~/code/mids/setup/seed_data/data/item_types.csv' 
IGNORE
INTO TABLE stage_item_types
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;


LOAD DATA INFILE '~/code/mids/setup/seed_data/data/suggested_items.csv' 
IGNORE
INTO TABLE stage_suggested_items
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

show warnings;

-- room types
insert into room_types (client_id, code, name)
select 0, code,name
from stage_room_types;


-- categories
INSERT INTO
 categories (
    name,
    user_id,
    client_id,
    system_or_user,
    system_type,
    user_type,
    phys_or_digi
  )
select
  name,
  null,
  0,
  system_or_user,
  system_type,
  user_type,
  phys_or_digi
from
  stage_categories;

  -- item_types
INSERT INTO
 item_types (
    user_id,
    category_id,
    dflt_room_type_id,
    client_id,
    name,
    code,
    include_in_wizard,
    optional_description,
    show_retailer,
    retailer_label,
    show_mfr,
    mfr_label,
    show_model_name,
    model_name_label,
    show_serial,
    serial_label,
    show_purch_date,
    purch_date_label,
    show_start_date,
    start_date_label,
    show_expiry_date,
    expiry_date_label,
    show_price_paid,
    price_paid_label,
    show_val_now,
    val_now_label,
    show_val_now_eff_date,
    val_now_eff_date_label,
    show_val_basis,
    val_basis_label,
    show_contact_phone,
    contact_phone_label
  )
select
  null,
  (select category_id from categories tc where tc.system_or_user = 'SYS' and tc.system_type = stage.category),
  (select room_type_id from room_types trt where trt.code = stage.dflt_room_code),
  0,
  name,
  code,
  include_in_wizard,
  optional_description,
  show_retailer,
  retailer_label,
  show_mfr,
  mfr_label,
  show_model_name,
  model_name_label,
  show_serial,
  serial_label,
  show_purch_date,
  purch_date_label,
  show_start_date,
  start_date_label,
  show_expiry_date,
  expiry_date_label,
  show_price_paid,
  price_paid_label,
  show_val_now,
  val_now_label,
  show_val_now_eff_date,
  val_now_eff_date_label,
  show_val_basis,
  val_basis_label,
  show_contact_phone,
  contact_phone_label
from
  stage_item_types stage;

-- suggested items

INSERT INTO suggested_items
(item_type_id,
client_id,
name,relevant_country)
select 
(select tit.item_type_id from item_types tit where tit.code = ssi.item_type_code),
0,
ssi.name,
ssi.relevant_country
from stage_suggested_items ssi;

