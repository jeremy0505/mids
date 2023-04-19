use mids;


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
    show_colour,
    colour_label,
    show_serial_number,
    serial_number_label,
    show_purch_date,
    purch_date_label,
    show_start_date,
    start_date_label,
    show_expiry_date,
    expiry_date_label,
    show_cost_initial,
    cost_initial_label,
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
  show_colour,
  colour_label,
  show_serial_number,
  serial_number_label,
  show_purch_date,
  purch_date_label,
  show_start_date,
  start_date_label,
  show_expiry_date,
  expiry_date_label,
  show_cost_initial,
  cost_initial_label,
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

