-- 
-- create sample data in all relevant tables

use mids;

SET SESSION sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

-- 
-- clients - just the zero record
--
insert into clients(client_id, name, cre_date)
values
(0,'B2C Client',now());


--
-- users - note the ability to insert multiple rows with just a single insert statement
--

insert into users
(id, client_id,email, secondary_email,password, mobile,first_name,last_name,postal_code,country,lang,currency,year_of_birth)
values
(1, 0,'asmith@example.com','asmith2@example.com', 'xxxxxxxx', '07770 123456','Alice','Smith','GU51 4HG','UK','EN','GBP', 1968),
(2, 0,'bjones@example.com','bjones2@example.com', 'xxxxxxxx', '07770 234567','Bobby','Jones','GU22 8RL','UK','EN','GBP', 1966),
(3, 0,'cgreen@example.com','cgreen2@example.com', 'xxxxxxxx', '07770 987654','Carla','Green','KT15 3NA','UK','EN','GBP', 1971),
(4, 0,'dwhite@example.com','dwhite2@example.com', 'xxxxxxxx', '07123 565656','Douglas','White','GU13 0LJ','UK','EN','GBP', 1967)
;


--
-- accounts
--

INSERT INTO
    accounts (
        account_owner_user_id,
        client_id,
        account_code
    )
VALUES
(1,0,'2022000017'),
(2,0,'2022000027'),
(3,0,'2022000442'),
(4,0,'2022000500')
;


--
-- account access
--


INSERT INTO user_account_access
(user_id,
account_id,
client_id,
date_granted,
access_mode)
VALUES
(1,1,0,now(),'OWNER'),
(2,2,0,now(),'OWNER'),
(3,3,0,now(),'OWNER'),
(4,4,0,now(),'OWNER')
;


--
-- a couple of plans
--


INSERT INTO plans
(plan_id,
client_id,
name,
description,
date_avail_start,
date_avail_end,
discounted_months,
discounted_fee,
revert_to_fee,
plan_code)
VALUES
(1,0,'INDIV_FREE','Basic free plan for an individual','2022-01-01 00:00:00',null,0,0,0,'IND_FREE'),
(2,0,'INDIV_BASIC','Individual plan','2022-01-01 00:00:00',null,0,0,24,'IND_BASIC')
;



--
-- user plans - with copies of terms as at time of contract

INSERT INTO user_plans
(user_id,
plan_id,
client_id,
from_name,
from_description,
from_date_avail_start,
from_date_avail_end,
from_discounted_months,
from_discounted_fee,
from_revert_to_fee)
VALUES
(1,1,0,'INDIV_FREE','Basic free plan for an individual','2022-01-01 00:00:00',null,0,0,0),
(2,1,0,'INDIV_FREE','Basic free plan for an individual','2022-01-01 00:00:00',null,0,0,0),
(3,2,0,'INDIV_FREE','Basic free plan for an individual','2022-01-01 00:00:00',null,0,0,0),
(4,2,0,'INDIV_FREE','Basic free plan for an individual','2022-01-01 00:00:00',null,0,0,0)
;


--
-- properties
--

INSERT INTO my_properties
(my_property_id,
user_id,
client_id,
friendly_name,
address1,
address2,
city,
county,
country,
postal_code,
property_status,
photo,
currency)
VALUES
(1,1,0,'Tavistock Towers','181 Tavistock Road',null,'Fleet','Hants','UK','GU51 4HG','PROP_ACTIVE',NULL,'GBP'),
(2,2,0,'Lincoln Lodge',null,null,null,null,'UK','GU22 8RL','PROP_ACTIVE',NULL,'GBP');

--
-- property rooms 
--


INSERT INTO my_property_rooms
(property_room_id,
my_property_id,
room_type_id,
client_id,
room_name,
comments)
VALUES
(1,1,1,0,'Master Bedroom',null),
(2,1,1,0,'Study',null),
(3,1,1,0,'Jane''s Bedroom',null),
(4,1,1,0,'Joe''s Bedroom',null),
(5,1,4,0,'Living room',null),
(6,1,4,0,'Family room',null),
(7,1,3,0,'Kitchen',null),
(8,1,5,0,'Dining room',null),
(9,1,7,0,'Utility',null);


--
-- and finally some items :)
--

INSERT INTO my_items
(item_type_id,
user_id,
my_property_id,
client_id,
version,
date_effective_from,
date_effective_to,
insured_by_my_item_id,
name,
qty,
model_name,
mfr,
serial_number,
purch_date,
start_date,
expiry_date,
price_paid,
val_now,
val_now_eff_date,
val_basis,
val_ins_purposes,
val_ins_purposes_date,
contact_phone,
comments,
status,
property_room_id,
num_days_pre_exp_notifs)
VALUES
(1,1,1,0,1,now(),null,null,'Integrated fridge',1,null,'AEG','8900928','2014-04-02',null,null,
           420,null,null,null,null,null,null,'Bought with the kitchen from benhmarx','ACTIVE',7,null),
(2,1,1,0,1,now(),null,null,'Integrated freezer',1,null,'AEG','8800928','2014-04-02',null,null,
           409,null,null,null,null,null,null,'Bought with the kitchen from benhmarx','ACTIVE',7,null),
(4,1,1,0,1,now(),null,null,'Washing m/c',1,null,'Bosch','00891872','2014-04-02',null,null,
           510,null,null,null,null,null,null,'','ACTIVE',9,null),
(6,1,1,0,1,now(),null,null,'Tumble dryer',1,null,'BEKO','109828/3-3','2014-04-02',null,null,
           250,null,null,null,null,null,null,'','ACTIVE',9,null),
(8,1,1,0,1,now(),null,null,'Range cooker',1,null,'Rangemaster','FG00PL22','2014-05-01',null,null,
           1200,null,null,null,null,null,null,'','ACTIVE',7,null),
(11,1,1,0,1,now(),null,null,'Samsung Smart TV',1,null,'Samsung','SG-00928UK','2014-06-12',null,null,
           720,null,null,null,null,null,null,'','ACTIVE',7,null),
(11,1,1,0,1,now(),null,null,'Samsung Smart TV',1,null,'Samsung','SG-00928UK','2015-06-02',null,null,
           650,null,null,null,null,null,null,'','ACTIVE',5,null),
(32,1,1,0,1,now(),null,null,'Leather sofa',2,null,'DFS','','2014-10-12',null,null,
           750,null,null,null,null,null,null,'','ACTIVE',7,null),
(32,1,1,0,1,now(),null,null,'Fabric barcelo sofa',1,null,'M&S','','2010-09-30',null,null,
           650,null,null,null,null,null,null,'','ACTIVE',5,null),
(35,1,1,0,1,now(),null,null,'Double bed',1,null,'','','2005-04-02',null,null,
           400,null,null,null,null,null,null,'','ACTIVE',1,null),
(38,1,1,0,1,now(),null,null,'Bedside unit',2,null,'','','2007-04-02',null,null,
           140,null,null,null,null,null,null,'','ACTIVE',1,null),
(41,1,1,0,1,now(),null,null,'Coffee table',1,null,'','','2004-02-15',null,null,
           310,null,null,null,null,null,null,'','ACTIVE',7,null),
(42,1,1,0,1,now(),null,null,'Dressing table',1,null,'','','2004-02-15',null,null,
           200,null,null,null,null,null,null,'','ACTIVE',7,null),
(47,1,1,0,1,now(),null,null,'Stool',2,null,'','','2004-02-15',null,null,
           35,null,null,null,null,null,null,'','ACTIVE',7,null);

