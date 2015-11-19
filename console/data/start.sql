CREATE TABLE databases
(
    id SERIAL PRIMARY KEY NOT NULL,
    dsn VARCHAR(255) NOT NULL,
    dbname VARCHAR(255) NOT NULL,
    dbms_id INT NOT NULL
);
CREATE TABLE databases_id_seq
(
    sequence_name VARCHAR NOT NULL,
    last_value BIGINT NOT NULL,
    start_value BIGINT NOT NULL,
    increment_by BIGINT NOT NULL,
    max_value BIGINT NOT NULL,
    min_value BIGINT NOT NULL,
    cache_value BIGINT NOT NULL,
    log_cnt BIGINT NOT NULL,
    is_cycled BOOL NOT NULL,
    is_called BOOL NOT NULL
);
CREATE TABLE dbms
(
    id SERIAL PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL
);
CREATE TABLE dbms_id_seq
(
    sequence_name VARCHAR NOT NULL,
    last_value BIGINT NOT NULL,
    start_value BIGINT NOT NULL,
    increment_by BIGINT NOT NULL,
    max_value BIGINT NOT NULL,
    min_value BIGINT NOT NULL,
    cache_value BIGINT NOT NULL,
    log_cnt BIGINT NOT NULL,
    is_cycled BOOL NOT NULL,
    is_called BOOL NOT NULL
);
CREATE TABLE events
(
    id SERIAL PRIMARY KEY NOT NULL,
    trigger_id INT NOT NULL,
    event_txt VARCHAR,
    created_date TIMESTAMP,
    is_show INT DEFAULT 0,
    is_success INT DEFAULT 0
);
CREATE TABLE events_id_seq
(
    sequence_name VARCHAR NOT NULL,
    last_value BIGINT NOT NULL,
    start_value BIGINT NOT NULL,
    increment_by BIGINT NOT NULL,
    max_value BIGINT NOT NULL,
    min_value BIGINT NOT NULL,
    cache_value BIGINT NOT NULL,
    log_cnt BIGINT NOT NULL,
    is_cycled BOOL NOT NULL,
    is_called BOOL NOT NULL
);
CREATE TABLE messages
(
    id SERIAL PRIMARY KEY NOT NULL,
    message VARCHAR,
    recipient_id INT,
    trigger_id INT NOT NULL,
    created_date TIMESTAMP DEFAULT now() NOT NULL
);
CREATE TABLE messages_id_seq
(
    sequence_name VARCHAR NOT NULL,
    last_value BIGINT NOT NULL,
    start_value BIGINT NOT NULL,
    increment_by BIGINT NOT NULL,
    max_value BIGINT NOT NULL,
    min_value BIGINT NOT NULL,
    cache_value BIGINT NOT NULL,
    log_cnt BIGINT NOT NULL,
    is_cycled BOOL NOT NULL,
    is_called BOOL NOT NULL
);
CREATE TABLE migration
(
    version VARCHAR(180) PRIMARY KEY NOT NULL,
    apply_time INT
);
CREATE TABLE projects
(
    id SERIAL PRIMARY KEY NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR NOT NULL,
    logo VARCHAR(255)
);
CREATE TABLE projects_id_seq
(
    sequence_name VARCHAR NOT NULL,
    last_value BIGINT NOT NULL,
    start_value BIGINT NOT NULL,
    increment_by BIGINT NOT NULL,
    max_value BIGINT NOT NULL,
    min_value BIGINT NOT NULL,
    cache_value BIGINT NOT NULL,
    log_cnt BIGINT NOT NULL,
    is_cycled BOOL NOT NULL,
    is_called BOOL NOT NULL
);
CREATE TABLE sections
(
    id SERIAL PRIMARY KEY NOT NULL,
    title VARCHAR(255) NOT NULL,
    project_id INT NOT NULL
);
CREATE TABLE sections_id_seq
(
    sequence_name VARCHAR NOT NULL,
    last_value BIGINT NOT NULL,
    start_value BIGINT NOT NULL,
    increment_by BIGINT NOT NULL,
    max_value BIGINT NOT NULL,
    min_value BIGINT NOT NULL,
    cache_value BIGINT NOT NULL,
    log_cnt BIGINT NOT NULL,
    is_cycled BOOL NOT NULL,
    is_called BOOL NOT NULL
);
CREATE TABLE triggers
(
    id SERIAL PRIMARY KEY NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR NOT NULL,
    importance INT NOT NULL,
    last_launch TIMESTAMP DEFAULT now() NOT NULL,
    db_id INT NOT NULL,
    section_id INT NOT NULL,
    user_create INT NOT NULL,
    is_active INT NOT NULL,
    trigger_type INT NOT NULL,
    code VARCHAR NOT NULL
);
CREATE TABLE triggers_id_seq
(
    sequence_name VARCHAR NOT NULL,
    last_value BIGINT NOT NULL,
    start_value BIGINT NOT NULL,
    increment_by BIGINT NOT NULL,
    max_value BIGINT NOT NULL,
    min_value BIGINT NOT NULL,
    cache_value BIGINT NOT NULL,
    log_cnt BIGINT NOT NULL,
    is_cycled BOOL NOT NULL,
    is_called BOOL NOT NULL
);
CREATE TABLE "user"
(
    id SERIAL PRIMARY KEY NOT NULL,
    username VARCHAR(255) NOT NULL,
    auth_key VARCHAR(32) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    password_reset_token VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    status SMALLINT DEFAULT 10 NOT NULL,
    created_at INT NOT NULL,
    updated_at INT NOT NULL,
    role VARCHAR(100) DEFAULT 'observer' NOT NULL
);
CREATE TABLE user_id_seq
(
    sequence_name VARCHAR NOT NULL,
    last_value BIGINT NOT NULL,
    start_value BIGINT NOT NULL,
    increment_by BIGINT NOT NULL,
    max_value BIGINT NOT NULL,
    min_value BIGINT NOT NULL,
    cache_value BIGINT NOT NULL,
    log_cnt BIGINT NOT NULL,
    is_cycled BOOL NOT NULL,
    is_called BOOL NOT NULL
);
ALTER TABLE databases ADD FOREIGN KEY (dbms_id) REFERENCES dbms (id);
CREATE INDEX dbms_id_index ON databases (dbms_id);
CREATE INDEX dbname_index ON databases (dbname);
ALTER TABLE events ADD FOREIGN KEY (trigger_id) REFERENCES triggers (id);
ALTER TABLE messages ADD FOREIGN KEY (trigger_id) REFERENCES triggers (id);
CREATE INDEX title_index ON projects (title);
ALTER TABLE sections ADD FOREIGN KEY (project_id) REFERENCES projects (id);
CREATE INDEX project_id_index ON sections (project_id);
ALTER TABLE triggers ADD FOREIGN KEY (db_id) REFERENCES databases (id);
ALTER TABLE triggers ADD FOREIGN KEY (section_id) REFERENCES sections (id);
CREATE UNIQUE INDEX user_email_key ON "user" (email);
CREATE UNIQUE INDEX user_password_reset_token_key ON "user" (password_reset_token);
CREATE UNIQUE INDEX user_username_key ON "user" (username);