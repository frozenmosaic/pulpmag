-- ALTER TABLE issue CHANGE issue_uid issue_id varchar(11);
ALTER TABLE issue CHANGE issue_vol volumn varchar(11);
ALTER TABLE issue CHANGE issue_no `number` varchar(11);
ALTER TABLE issue CHANGE issue_year year varchar(11);
ALTER TABLE issue CHANGE issue_date `date` varchar(11);


ALTER TABLE item CHANGE item_uid item_id varchar(16);
ALTER TABLE item CHANGE item_url url varchar(16);

ALTER TABLE page CHANGE text_uid page_id char(25);
