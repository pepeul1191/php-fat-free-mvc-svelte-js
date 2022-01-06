-- migrate:up

INSERT INTO states (id, name) VALUES
  (1, 'active'),
  (2, 'deleted'),
  (3, 'suspended');

-- migrate:down

DELETE FROM states;