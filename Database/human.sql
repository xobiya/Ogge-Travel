CREATE DATABASE hrms;
USE hrms;

-- 1. Employees Table
CREATE TABLE employees (
    employee_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15),
    gender ENUM('Male', 'Female', 'Other'),
    date_of_birth DATE,
    hire_date DATE NOT NULL,
    job_title VARCHAR(100),
    department_id INT,
    salary DECIMAL(10,2),
    status ENUM('Active', 'Resigned', 'Terminated') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(department_id) ON DELETE SET NULL
);

-- 2. Departments Table
CREATE TABLE departments (
    department_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Attendance Table
CREATE TABLE attendance (
    attendance_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    check_in DATETIME,
    check_out DATETIME,
    hours_worked DECIMAL(5,2),
    overtime DECIMAL(5,2) DEFAULT 0.00,
    status ENUM('Present', 'Absent', 'On Leave', 'Late') DEFAULT 'Present',
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id) ON DELETE CASCADE
);

-- 4. Payroll Table
CREATE TABLE payroll (
    payroll_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    salary DECIMAL(10,2),
    deductions DECIMAL(10,2) DEFAULT 0.00,
    net_salary DECIMAL(10,2),
    payment_date DATE,
    payment_status ENUM('Pending', 'Paid') DEFAULT 'Pending',
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id) ON DELETE CASCADE
);

-- 5. Leaves Table
CREATE TABLE leaves (
    leave_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    leave_type ENUM('Sick Leave', 'Vacation', 'Maternity Leave', 'Paternity Leave', 'Unpaid Leave'),
    start_date DATE,
    end_date DATE,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    applied_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id) ON DELETE CASCADE
);

-- 6. Performance Reviews Table
CREATE TABLE performance_reviews (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    reviewer_id INT,
    review_date DATE,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comments TEXT,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id) ON DELETE CASCADE,
    FOREIGN KEY (reviewer_id) REFERENCES employees(employee_id) ON DELETE SET NULL
);

-- 7. Training Table
CREATE TABLE training (
    training_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    start_date DATE,
    end_date DATE,
    trainer VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 8. Employee Training Table
CREATE TABLE employee_training (
    record_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    training_id INT,
    completion_status ENUM('Pending', 'Completed') DEFAULT 'Pending',
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id) ON DELETE CASCADE,
    FOREIGN KEY (training_id) REFERENCES training(training_id) ON DELETE CASCADE
);

-- 9. Resignations Table
CREATE TABLE resignations (
    resignation_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    resignation_date DATE,
    last_working_day DATE,
    reason TEXT,
    status ENUM('Pending', 'Accepted', 'Rejected') DEFAULT 'Pending',
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id) ON DELETE CASCADE
);

-- 10. Employee Documents Table
CREATE TABLE employee_documents (
    document_id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    document_name VARCHAR(255),
    document_type ENUM('Resume', 'ID Proof', 'Contract', 'Certificate'),
    document_url VARCHAR(255),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id) ON DELETE CASCADE
);