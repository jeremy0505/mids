drop function if exists mids.mfr_strip;

DELIMITER $$
CREATE FUNCTION mids.mfr_strip(
p_mfr varchar(240)
)
RETURNS VARCHAR(240)
DETERMINISTIC
BEGIN
-- want to strip the parameter to make it a single word, lowercase, no punctuation

declare x int;
declare str varchar(240);

set str = trim(lower(p_mfr));

-- find 1st space
set x = locate(' ',str);
if x = 0 then
  set x = length(str)+1;
end if;
-- ignore everything after the 1st space

set str = substr(str,1,x-1);

-- strip out other potential extraneous chars
set str = replace(str,'.','');
set str = replace(str,'_','');
set str = replace(str,'-','');
set str = replace(str,'/','');
set str = replace(str,'''','');
return str;


END$$
DELIMITER ;


