use mids;

--
-- script to drop all MIDS tables *plus* the "users" table which we create 
-- with additional attributes
--

drop table if exists stage_categories, stage_item_types, stage_room_types, stage_suggested_items,sample_my_items;

drop table if exists user_account_access;
drop table if exists accounts;
drop table if exists audit_log;
drop table if exists dml_log;
drop table if exists emails;
drop table if exists inbound_email_attachments;
drop table if exists inbound_emails;
drop table if exists login_attempts;
drop table if exists user_plans;
drop table if exists my_item_docs;
drop table if exists my_item_extra_fields;
drop table if exists my_items;
drop table if exists my_property_rooms;
drop table if exists nominee_obj_grants;
drop table if exists payment_history;
drop table if exists pending_items;
drop table if exists plans;
drop table if exists syslog;
drop table if exists trace;

drop table if exists my_nominees;

drop table if exists my_properties;

drop table if exists suggested_items;
drop table if exists item_type_extra_fields;
drop table if exists item_types;

drop table if exists users;
drop table if exists mids_users;
drop table if exists categories;
drop table if exists room_types;
drop table if exists clients;

drop table if exists suggested_items;

drop view if exists v_my_items;
drop view if exists v_my_property_rooms;





// clean up

delete from personal_access_tokens;
