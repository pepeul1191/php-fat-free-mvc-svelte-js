-- migrate:up

CREATE TABLE 'states' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'name'	VARCHAR(15) NOT NULL
);

-- migrate:down

DROP TABLE IF EXISTS 'states';