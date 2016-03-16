CREATE TABLE users (
  u_name  VARCHAR(40) PRIMARY KEY,
  u_email VARCHAR(320) NOT NULL UNIQUE
);

CREATE TABLE projects (
  p_id   SERIAL PRIMARY KEY,
  p_name VARCHAR(40) NOT NULL UNIQUE,
  p_user VARCHAR(40) NOT NULL,
  FOREIGN KEY (p_user) REFERENCES users (u_name) ON DELETE CASCADE
);

CREATE TABLE tasks (
  t_project     BIGINT UNSIGNED,
  t_id          SERIAL PRIMARY KEY,
  t_user        VARCHAR(40) NOT NULL,
  t_title       VARCHAR(60) NOT NULL,
  t_description TEXT,
  t_stage       ENUM('to do', 'in progress', 'in review', 'done') DEFAULT 'to do' NOT NULL,
  t_time        TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  FOREIGN KEY (t_project) REFERENCES projects (p_id) ON DELETE CASCADE,
  FOREIGN KEY (t_user) REFERENCES users (u_name) ON DELETE CASCADE
);

CREATE TABLE comments (
  c_task   BIGINT UNSIGNED,
  c_id     SERIAL PRIMARY KEY,
  c_user   VARCHAR(40) NOT NULL,
  c_text   TEXT NOT NULL,
  c_time   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (c_task) REFERENCES tasks (t_id) ON DELETE CASCADE,
  FOREIGN KEY (c_user) REFERENCES users (u_name) ON DELETE CASCADE
);
