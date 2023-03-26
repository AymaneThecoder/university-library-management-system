

-- This is the trigger that will decrement the borrows left for a user
-- when he made a borrow 

DELIMITER $
CREATE or REPLACE TRIGGER dec_user_borrows AFTER
INSERT on borrows 
FOR EACH ROW
BEGIN
UPDATE users set borrows_left = borrows_left - 1 WHERE users.userId = new.userId
END $
DELIMITER ;