# employemanagement-anchal
SELECT *
FROM  `salaries`
WHERE employee_id =7
ORDER BY  `created` DESC
LIMIT 1


SELECT call GetAllemployees( 7, @curr_mgr_name , @curr_sal , @curr_dept , @cur_title , @dob , @gender , @hiredate , @lasttitle )



DROP PROCEDURE `GetAllEmployees`//
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllEmployees`(IN empid INT,
  OUT curr_mgr_name varchar(100),
  OUT curr_sal INT,
  OUT curr_dept varchar(100),
  OUT curr_title varchar(100),
  OUT D_O_F date,
  OUT GEN varchar(10),
  OUT HIR_DATE date
)
BEGIN

 select gender,dob,hire_date INTO GEN,D_O_F,HIR_DATE from employees where id=empid;

SELECT m.name  INTO curr_mgr_name
 FROM employees e
INNER JOIN employees m ON m.id = e.`manager_id`
WHERE e.id =empid;


SELECT salary INTO curr_sal
    FROM salaries
WHERE employee_id =empid
ORDER BY  `created` DESC
LIMIT 1;

SELECT name INTO curr_dept
  FROM departments
    WHERE id = (
    SELECT department_id
   FROM departments_employees
   WHERE employee_id =empid
   ORDER BY  created DESC
   LIMIT 1 ) ;

 SELECT title INTO curr_title
FROM job_titles
WHERE id = (
SELECT job_title_id
FROM employees_titles
WHERE employee_id =empid
ORDER BY created DESC
LIMIT 1 ) ;

END


employee_id, -->ok
current_manager_name--ok,
current_salary==>ok,
current_department->ok,
current_department_manager(-------),
current_title-->ok,
hire_date--ok,
gender--ok,
dob--ok,
last_title--(ok),
last_salary,
last_title_from_date,
last_title_to_date,
last_department_name: (if change "name of dept" else 'same as current')
salary_hike_in_percentage



SELECT title FROM job_titles WHERE id = (  SELECT IFNULL( (  SELECT job_title_id FROM employees_titles WHERE employee_id =7 ORDER BY created DESC  LIMIT 1,2 ),  'kfjdhg' ) )
 
 SELECT salary, created
 FROM  `salaries` 
 WHERE  `employee_id` =7
 ORDER BY created DESC 
 LIMIT 1 , 1