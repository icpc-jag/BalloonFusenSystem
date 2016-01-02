CREATE TABLE contest (
  contest_name varchar(191) NOT NULL,
  pass_code varchar(191) NOT NULL,
  staff_code varchar(191) NOT NULL,
  PRIMARY KEY (contest_name)
) ENGINE=InnoDB;

CREATE TABLE ac (
  id int(10) NOT NULL AUTO_INCREMENT,
  contest_name varchar(191) NOT NULL,
  problem_name varchar(191) NOT NULL,
  team_id varchar(191) NOT NULL,
  user_name varchar(191) NULL,
  state int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  INDEX (contest_name, id)
) ENGINE=InnoDB;

CREATE TABLE team (
  contest_name varchar(191) NOT NULL,
  team_id varchar(191) NOT NULL,
  team_name varchar(191) NOT NULL,
  seat varchar(191) NOT NULL DEFAULT '',
  PRIMARY KEY (contest_name, team_id)
) ENGINE=InnoDB;

CREATE TABLE clar (
  contest_name varchar(191) NOT NULL,
  clar_hash varchar(191) NOT NULL,
  PRIMARY KEY (contest_name)
) ENGINE=InnoDB;
