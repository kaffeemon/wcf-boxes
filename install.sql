DROP TABLE IF EXISTS wcf1_box;
CREATE TABLE wcf1_box (
	boxID		INT(10)			NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name		VARCHAR(255)	NOT NULL,
	title		VARCHAR(255)	NOT NULL,
	options		TEXT			NOT NULL,
	className	VARCHAR(255)	NOT NULL,
	style		enum('title', 'border', 'none') NOT NULL DEFAULT 'title',
	
	UNIQUE KEY (name)
);
