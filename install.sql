DROP TABLE IF EXISTS wcf1_box;
CREATE TABLE wcf1_box (
	boxID		INT(10)			NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name		VARCHAR(255)	NOT NULL,
	title		VARCHAR(255)	NOT NULL,
	options		TEXT			NOT NULL,
	boxTypeID	INT(10)			NOT NULL,
	style		enum('title', 'border', 'blank') NOT NULL DEFAULT 'title',
	disabled	TINYINT(1)		NOT NULL DEFAULT 0,
	
	UNIQUE KEY (name)
);

ALTER TABLE wcf1_box ADD FOREIGN KEY (boxTypeID) REFERENCES wcf1_object_type (objectTypeID) ON DELETE CASCADE;
