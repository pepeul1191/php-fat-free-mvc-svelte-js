-- migrate:up

CREATE TABLE 'users' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'user'	VARCHAR(25) NOT NULL,
  'password'	VARCHAR(80),
  'email'	VARCHAR(30) NOT NULL,
  'url_picture'	VARCHAR(100) NOT NULL,
  'reset_key'	VARCHAR(15) NOT NULL,
  'activation_key'	VARCHAR(15) NOT NULL,
  'active'	BOOLEAN NOT NULL
);

-- migrate:down

DROP TABLE IF EXISTS 'users';