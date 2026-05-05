-- GradMapper Database Schema
-- MySQL Database for Higher Education Planning Platform
-- Created for u748207893_gradmapperdb

-- ============================================
-- 1. CORE TABLES - Universities & Programs
-- ============================================

CREATE TABLE universities (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL UNIQUE,
  city VARCHAR(100) NOT NULL,
  state VARCHAR(2) NOT NULL,
  country VARCHAR(100) DEFAULT 'USA',
  website_url VARCHAR(255),
  phone VARCHAR(20),
  established_year INT,
  student_population INT,
  acceptance_rate DECIMAL(5, 2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_state_city (state, city),
  INDEX idx_acceptance_rate (acceptance_rate)
);

CREATE TABLE programs (
  id INT PRIMARY KEY AUTO_INCREMENT,
  university_id INT NOT NULL,
  program_name VARCHAR(255) NOT NULL,
  degree_type ENUM('Associates', 'Bachelors', 'Masters', 'PhD', 'Certificate') NOT NULL,
  field_of_study VARCHAR(100) NOT NULL,
  duration_years INT,
  program_url VARCHAR(255),
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (university_id) REFERENCES universities(id) ON DELETE CASCADE,
  INDEX idx_university_id (university_id),
  INDEX idx_field_of_study (field_of_study),
  INDEX idx_degree_type (degree_type)
);

-- ============================================
-- 2. ADMISSIONS REQUIREMENTS
-- ============================================

CREATE TABLE admissions_requirements (
  id INT PRIMARY KEY AUTO_INCREMENT,
  program_id INT NOT NULL,
  min_gpa DECIMAL(3, 2),
  min_sat_score INT,
  min_act_score INT,
  gre_required BOOLEAN DEFAULT FALSE,
  gmat_required BOOLEAN DEFAULT FALSE,
  toefl_required BOOLEAN DEFAULT FALSE,
  application_fee DECIMAL(10, 2),
  application_deadline DATE,
  application_url VARCHAR(255),
  early_action_deadline DATE,
  early_decision_deadline DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE,
  INDEX idx_program_id (program_id),
  INDEX idx_min_gpa (min_gpa),
  INDEX idx_min_sat (min_sat_score)
);

-- ============================================
-- 3. COST & FINANCIAL AID
-- ============================================

CREATE TABLE tuition_costs (
  id INT PRIMARY KEY AUTO_INCREMENT,
  program_id INT NOT NULL,
  tuition_per_year DECIMAL(12, 2),
  fees_per_year DECIMAL(10, 2),
  room_and_board DECIMAL(10, 2),
  books_and_supplies DECIMAL(10, 2),
  personal_expenses DECIMAL(10, 2),
  transportation DECIMAL(10, 2),
  total_cost_per_year DECIMAL(12, 2),
  total_program_cost DECIMAL(12, 2),
  in_state BOOLEAN DEFAULT FALSE,
  academic_year VARCHAR(10),
  currency VARCHAR(3) DEFAULT 'USD',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE,
  INDEX idx_program_id (program_id),
  INDEX idx_total_cost (total_cost_per_year)
);

CREATE TABLE financial_aid (
  id INT PRIMARY KEY AUTO_INCREMENT,
  program_id INT NOT NULL,
  avg_grant_per_student DECIMAL(10, 2),
  avg_loan_per_student DECIMAL(10, 2),
  avg_scholarship_per_student DECIMAL(10, 2),
  percent_receiving_aid DECIMAL(5, 2),
  percent_receiving_federal_aid DECIMAL(5, 2),
  percent_receiving_institutional_aid DECIMAL(5, 2),
  avg_student_debt_at_graduation DECIMAL(12, 2),
  merit_aid_available BOOLEAN DEFAULT TRUE,
  need_based_aid_available BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE,
  INDEX idx_program_id (program_id)
);

-- ============================================
-- 4. CURRICULUM & ACADEMICS
-- ============================================

CREATE TABLE curriculum (
  id INT PRIMARY KEY AUTO_INCREMENT,
  program_id INT NOT NULL,
  total_credits_required INT,
  core_curriculum_credits INT,
  elective_credits INT,
  internship_required BOOLEAN DEFAULT FALSE,
  capstone_project BOOLEAN DEFAULT FALSE,
  study_abroad_offered BOOLEAN DEFAULT FALSE,
  accreditation_body VARCHAR(100),
  accreditation_status ENUM('Accredited', 'Provisionally Accredited', 'Not Accredited'),
  curriculum_url VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE,
  INDEX idx_program_id (program_id)
);

CREATE TABLE course_requirements (
  id INT PRIMARY KEY AUTO_INCREMENT,
  program_id INT NOT NULL,
  course_name VARCHAR(255) NOT NULL,
  course_code VARCHAR(20),
  credits INT,
  is_required BOOLEAN DEFAULT TRUE,
  semester_offered VARCHAR(50),
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE,
  INDEX idx_program_id (program_id)
);

-- ============================================
-- 5. CAREER OUTCOMES & ROI
-- ============================================

CREATE TABLE career_outcomes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  program_id INT NOT NULL,
  graduation_rate DECIMAL(5, 2),
  employment_rate_6_months DECIMAL(5, 2),
  median_starting_salary DECIMAL(12, 2),
  median_salary_10_years DECIMAL(12, 2),
  avg_salary_range_low DECIMAL(12, 2),
  avg_salary_range_high DECIMAL(12, 2),
  top_employers VARCHAR(500),
  common_job_titles VARCHAR(500),
  grad_school_placement_rate DECIMAL(5, 2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE,
  INDEX idx_program_id (program_id),
  INDEX idx_median_salary (median_starting_salary),
  INDEX idx_employment_rate (employment_rate_6_months)
);

CREATE TABLE roi_metrics (
  id INT PRIMARY KEY AUTO_INCREMENT,
  program_id INT NOT NULL,
  total_cost_4_years DECIMAL(12, 2),
  avg_starting_salary DECIMAL(12, 2),
  avg_salary_5_years DECIMAL(12, 2),
  avg_salary_10_years DECIMAL(12, 2),
  payback_period_years DECIMAL(5, 1),
  roi_percentage DECIMAL(8, 2),
  lifetime_earnings_estimate DECIMAL(15, 2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE,
  INDEX idx_program_id (program_id),
  INDEX idx_roi_percentage (roi_percentage)
);

-- ============================================
-- 6. USER DATA - WAITLIST & TRACKING
-- ============================================

CREATE TABLE waitlist (
  id INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL UNIQUE,
  user_type ENUM('Student', 'Parent', 'Counselor', 'School Leader', 'University', 'Other') DEFAULT 'Student',
  status ENUM('Active', 'Unsubscribed', 'Bounced') DEFAULT 'Active',
  subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  unsubscribed_at TIMESTAMP NULL,
  source VARCHAR(100) DEFAULT 'Website',
  notes TEXT,
  INDEX idx_email (email),
  INDEX idx_status (status)
);

CREATE TABLE user_profiles (
  id INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL UNIQUE,
  first_name VARCHAR(100),
  last_name VARCHAR(100),
  user_type ENUM('Student', 'Parent', 'Counselor', 'School Leader', 'University') DEFAULT 'Student',
  high_school_grad_year INT,
  intended_gpa_range VARCHAR(20),
  target_salary_range VARCHAR(50),
  preferred_states VARCHAR(500),
  preferred_fields_of_study VARCHAR(500),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_email (email),
  INDEX idx_user_type (user_type)
);

CREATE TABLE user_comparisons (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  program_id INT NOT NULL,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  notes TEXT,
  FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE,
  INDEX idx_program_id (program_id),
  INDEX idx_added_at (added_at)
);

CREATE TABLE survey_responses (
  id INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255),
  survey_type ENUM('Student', 'Parent', 'Counselor', 'School Leader', 'University') NOT NULL,
  response_data JSON,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  survey_url VARCHAR(255),
  INDEX idx_email (email),
  INDEX idx_survey_type (survey_type)
);

-- ============================================
-- 7. RANKINGS & REVIEWS
-- ============================================

CREATE TABLE program_rankings (
  id INT PRIMARY KEY AUTO_INCREMENT,
  program_id INT NOT NULL,
  ranking_source VARCHAR(100),
  overall_rank INT,
  category VARCHAR(100),
  category_rank INT,
  ranking_year INT,
  score DECIMAL(5, 2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE,
  INDEX idx_program_id (program_id),
  INDEX idx_ranking_source (ranking_source)
);

CREATE TABLE reviews (
  id INT PRIMARY KEY AUTO_INCREMENT,
  program_id INT NOT NULL,
  reviewer_email VARCHAR(255),
  rating INT CHECK (rating >= 1 AND rating <= 5),
  title VARCHAR(255),
  review_text TEXT,
  category ENUM('Overall', 'Academics', 'Career Outcomes', 'Value for Money', 'Campus Life', 'Admissions'),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  helpful_count INT DEFAULT 0,
  FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE,
  INDEX idx_program_id (program_id),
  INDEX idx_rating (rating)
);

-- ============================================
-- 8. DATA MANAGEMENT TABLES
-- ============================================

CREATE TABLE data_sources (
  id INT PRIMARY KEY AUTO_INCREMENT,
  source_name VARCHAR(255) NOT NULL,
  source_url VARCHAR(255),
  last_updated DATE,
  data_type ENUM('Admissions', 'Cost', 'Career', 'Curriculum', 'Rankings', 'General'),
  reliability_score INT DEFAULT 5,
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE audit_log (
  id INT PRIMARY KEY AUTO_INCREMENT,
  table_name VARCHAR(100),
  record_id INT,
  action ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
  old_values JSON,
  new_values JSON,
  changed_by VARCHAR(100),
  changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_table_action (table_name, action),
  INDEX idx_changed_at (changed_at)
);

-- ============================================
-- INDEXES FOR COMMON QUERIES
-- ============================================

CREATE INDEX idx_university_state ON universities(state);
CREATE INDEX idx_program_field ON programs(field_of_study);
CREATE INDEX idx_cost_range ON tuition_costs(total_cost_per_year);
CREATE INDEX idx_salary_outcome ON career_outcomes(median_starting_salary);
