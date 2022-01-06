CREATE TABLE IF NOT EXISTS "schema_migrations" (version varchar(255) primary key);
CREATE TABLE IF NOT EXISTS 'systems' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'name'	VARCHAR(25) NOT NULL,
  'description'	TEXT NOT NULL,
  'repository'	VARCHAR(50) NOT NULL,
  'branch'	VARCHAR(15) NOT NULL,
  'key'	VARCHAR(10) NOT NULL,
  'value'	VARCHAR(15) NOT NULL
);
CREATE TABLE sqlite_sequence(name,seq);
CREATE TABLE IF NOT EXISTS 'states' (
	'id'	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	'name'	VARCHAR(15) NOT NULL
);
-- Dbmate schema migrations
INSERT INTO "schema_migrations" (version) VALUES
  ('20220105205229'),
  ('20220106020421'),
  ('20220106021158');
