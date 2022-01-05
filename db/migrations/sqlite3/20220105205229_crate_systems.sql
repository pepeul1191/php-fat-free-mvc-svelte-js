-- migrate:up

CREATE TABLE 'systems' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'name'	VARCHAR(25) NOT NULL,
  'description'	TEXT NOT NULL,
  'repository'	VARCHAR(50) NOT NULL,
  'branch'	VARCHAR(15) NOT NULL,
  'key'	VARCHAR(10) NOT NULL,
  'value'	VARCHAR(15) NOT NULL
);

-- migrate:down

DROP TABLE IF EXISTS 'systems';