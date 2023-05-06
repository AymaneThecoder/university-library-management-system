

-- This is the trigger that will decrement the borrows left for a user
-- when he made a borrow 

DELIMITER $
CREATE or REPLACE TRIGGER trig_borrows_insert AFTER
INSERT on borrows 
FOR EACH ROW
BEGIN
UPDATE users set borrows_left = borrows_left - 1 WHERE users.userId = new.userId
UPDATE documents set copiesLeft = copiesLeft - 1 WHERE id = new.docId;
END $
DELIMITER ;