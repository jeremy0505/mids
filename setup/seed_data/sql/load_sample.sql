use mids;


DELETE FROM sample_my_items;

LOAD DATA INFILE '~/code/mids/setup/test_data/sample_my_items.csv' 
INTO TABLE sample_my_items 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;


