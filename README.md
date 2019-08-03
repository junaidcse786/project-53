8# HR Project
 Project from Azman; HR and all

# How to install the project
1. copy all the folders to a new folder in htdocs
2. say, the folder name is "project-52"
3. create a database for your project
4. import the sql file *project-52.sql* in your database
5. change the database credentials e.g. user_name, password, db_name in the config file. You can find it in config/dbconnect.php
6. now go to the table "ecom_config" and update the records for SITE_NAME, SITE_URL and SITE_URL_ADMIN
     SITE_URL = URL to access the folder in htdocs
     SITE_URL_ADMIN = URL to access the folder in htdocs
     SITE_NAME = Name of the application
7. sign in as admin and you can change the role id for the employees
     go to setup and configuration
          change the value of the variable EMP_ROLE_ID
