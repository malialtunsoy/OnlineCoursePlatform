import java.sql.*;
public class Database{

    public static void main(String[] args){
    try {
        Class.forName("com.mysql.cj.jdbc.Driver");
    } catch (Exception e) {
        System.out.println("Driver not found");
        e.printStackTrace();
    }

    final String USERNAME = "ali.altunsoy";
    final String PASSWORD = "WkhYQAxv";
    final String DBNAME = "ali_altunsoy";
    final String URL = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/" + DBNAME;

    Connection connection = null;
    try{
        connection = DriverManager.getConnection(URL, USERNAME, PASSWORD);
    }
    catch (SQLException e){
        System.out.println("Connection failed");
        e.printStackTrace();
    }

    Statement stmt;

    try{
        stmt = connection.createStatement();

        //Drop Tables
        
        stmt.executeUpdate("DROP TABLE IF EXISTS wishes;");
        stmt.executeUpdate("DROP TABLE IF EXISTS owns;");
        stmt.executeUpdate("DROP TABLE IF EXISTS watched;");
        stmt.executeUpdate("DROP TABLE IF EXISTS notes;");
        stmt.executeUpdate("DROP TABLE IF EXISTS announces;");
        stmt.executeUpdate("DROP TABLE IF EXISTS question;");

        stmt.executeUpdate("DROP TABLE IF EXISTS discountoffer;");
        stmt.executeUpdate("DROP TABLE IF EXISTS requestrefund;");
        stmt.executeUpdate("DROP TABLE IF EXISTS complaint;");
        stmt.executeUpdate("DROP TABLE IF EXISTS rating;");
        stmt.executeUpdate("DROP TABLE IF EXISTS posts;");
        stmt.executeUpdate("DROP TABLE IF EXISTS follows;");

        stmt.executeUpdate("DROP TABLE IF EXISTS lecture;");
        stmt.executeUpdate("DROP TABLE IF EXISTS course;");
       
       
        
       
        
        
        
        
        
        
        stmt.executeUpdate("DROP TABLE IF EXISTS user;");
        stmt.executeUpdate("DROP TABLE IF EXISTS siteadmin;");
        stmt.executeUpdate("DROP TABLE IF EXISTS coursecreator;");
        stmt.executeUpdate("DROP TABLE IF EXISTS account;");
        stmt.executeUpdate("DROP VIEW  IF EXISTS total_courses;");

        System.out.println("Tables dropped.");
        //Create Tables
        System.out.println("\nCreating tables...");
        stmt.executeUpdate("CREATE TABLE account ("+
            "username VARCHAR(32) PRIMARY KEY, "+
            "password VARCHAR(32) NOT NULL,"+
            "email VARCHAR(32) NOT NULL UNIQUE) "+
            "ENGINE=innodb;");
        System.out.println("account table created.");

        stmt.executeUpdate("CREATE TABLE user ("+
            "username VARCHAR(32) PRIMARY KEY, "+
            "balance INT,"+
            "FOREIGN KEY (username) REFERENCES account(username))"+
            "ENGINE=innodb;");
        System.out.println("user table created.");

        stmt.executeUpdate("CREATE TABLE coursecreator ("+
            "username VARCHAR(32) PRIMARY KEY, "+
            "income INT,"+
            "FOREIGN KEY (username) REFERENCES account(username))"+
            "ENGINE=innodb;");
        System.out.println("coursecreator table created.");

        stmt.executeUpdate("CREATE TABLE siteadmin ("+
            "username VARCHAR(32) PRIMARY KEY, "+
            "FOREIGN KEY (username) REFERENCES account(username))"+
            "ENGINE=innodb;");
        System.out.println("siteadmin table created.");

        stmt.executeUpdate("CREATE TABLE course ("+
            "course_id INT PRIMARY KEY,"+
            "course_name VARCHAR(32),"+
            "course_desc VARCHAR(32),"+
            "course_fee FLOAT,"+
            "username VARCHAR(32),"+
            "discount_allow INT,"+
            "FOREIGN KEY (username) REFERENCES coursecreator(username))"+
            "ENGINE=innodb;");
        System.out.println("course table created.");

        stmt.executeUpdate("CREATE TABLE lecture ("+
            "lecture_id INT PRIMARY KEY,"+
            "lecture_name VARCHAR(32),"+
            "lecture_index INT,"+
            "lecture_description VARCHAR(1000),"+
            "video_url VARCHAR(100),"+
            "course_id INT,"+
            "FOREIGN KEY (course_id) REFERENCES course(course_id))"+
            "ENGINE=innodb;");
        System.out.println("lecture table created.");

        stmt.executeUpdate("CREATE TABLE wishes ("+
            "username VARCHAR(32),"+
            "course_id INT,"+
            "PRIMARY KEY (username, course_id),"+
            "FOREIGN KEY (username) REFERENCES user(username),"+
            "FOREIGN KEY (course_id) REFERENCES course(course_id))"+
            "ENGINE=innodb;");
        System.out.println("wishes table created.");

        stmt.executeUpdate("CREATE TABLE owns ("+
            "username VARCHAR(32),"+
            "course_id INT,"+
            "PRIMARY KEY (username, course_id),"+
            "FOREIGN KEY (username) REFERENCES user(username),"+
            "FOREIGN KEY (course_id) REFERENCES course(course_id))"+
            "ENGINE=innodb;");
        System.out.println("owns table created.");

        stmt.executeUpdate("CREATE TABLE watched ("+
            "username VARCHAR(32),"+
            "lecture_id INT,"+
            "PRIMARY KEY (username, lecture_id),"+
            "FOREIGN KEY (username) REFERENCES user(username),"+
            "FOREIGN KEY (lecture_id) REFERENCES lecture(lecture_id))"+
            "ENGINE=innodb;");
        System.out.println("watched table created.");

        stmt.executeUpdate("CREATE TABLE notes ("+
            "username VARCHAR(32),"+
            "lecture_id INT,"+
            "note VARCHAR(1000),"+
            "PRIMARY KEY (username, lecture_id),"+
            "FOREIGN KEY (username) REFERENCES user(username),"+
            "FOREIGN KEY (lecture_id) REFERENCES lecture(lecture_id))"+
            "ENGINE=innodb;");
        System.out.println("notes table created.");

        stmt.executeUpdate("CREATE TABLE announces ("+
            "course_id INT,"+
            "title VARCHAR(50),"+
            "announcement VARCHAR(1000),"+
            "timestamp TIME,"+
            "username VARCHAR(32),"+
            "PRIMARY KEY (course_id, timestamp, username),"+
            "FOREIGN KEY (username) REFERENCES coursecreator(username),"+
            "FOREIGN KEY (course_id) REFERENCES course(course_id))"+
            "ENGINE=innodb;");
        System.out.println("announces table created.");

        stmt.executeUpdate("CREATE TABLE question ("+
            "course_id INT,"+
            "username VARCHAR(32),"+
            "question_title VARCHAR(50),"+
            "question VARCHAR(1000),"+
            "answer VARCHAR(1000),"+
            "question_time TIME,"+
            "answer_time TIME,"+
            "PRIMARY KEY (course_id, question_time, username),"+
            "FOREIGN KEY (username) REFERENCES user(username),"+
            "FOREIGN KEY (course_id) REFERENCES course(course_id))"+
            "ENGINE=innodb;");
        System.out.println("question table created.");

        stmt.executeUpdate("CREATE TABLE discountoffer ("+
            "admin_username VARCHAR(32),"+
            "creator_username VARCHAR(32),"+
            "course_id INT,"+
            "discount_amount INT,"+
            "status VARCHAR(32),"+
            "PRIMARY KEY (admin_username, creator_username, course_id),"+
            "FOREIGN KEY (admin_username) REFERENCES siteadmin(username),"+
            "FOREIGN KEY (creator_username) REFERENCES coursecreator(username),"+
            "FOREIGN KEY (course_id) REFERENCES course(course_id))"+
            "ENGINE=innodb;");
        System.out.println("discountoffer table created.");

        stmt.executeUpdate("CREATE TABLE requestrefund ("+
            "username VARCHAR(32),"+
            "course_id INT,"+
            "title VARCHAR(100),"+
            "reason VARCHAR(500),"+
            "status VARCHAR(50),"+
            "PRIMARY KEY (username, course_id),"+
            "FOREIGN KEY (username) REFERENCES user(username),"+
            "FOREIGN KEY (course_id) REFERENCES course(course_id))"+
            "ENGINE=innodb;");
        System.out.println("requestrefund table created.");

        stmt.executeUpdate("CREATE TABLE complaint ("+
            "user_username VARCHAR(32),"+
            "admin_username VARCHAR(32),"+
            "course_id INT,"+
            "title VARCHAR(50),"+
            "reason VARCHAR(1000),"+
            "answer VARCHAR(1000),"+
            "PRIMARY KEY (user_username, course_id, title),"+
            "FOREIGN KEY (user_username) REFERENCES account(username),"+
            "FOREIGN KEY (admin_username) REFERENCES siteadmin(username),"+
            "FOREIGN KEY (course_id) REFERENCES course(course_id))"+
            "ENGINE=innodb;");
        System.out.println("complaint table created.");

        stmt.executeUpdate("CREATE TABLE rating ("+
            "username VARCHAR(32),"+
            "course_id INT,"+
            "rate INT,"+
            "PRIMARY KEY (username, course_id),"+
            "FOREIGN KEY (username) REFERENCES user(username),"+
            "FOREIGN KEY (course_id) REFERENCES course(course_id))"+
            "ENGINE=innodb;");
        System.out.println("rating table created.");

        stmt.executeUpdate("CREATE TABLE posts ("+
            "username VARCHAR(32),"+
            "post_title VARCHAR(100),"+
            "content VARCHAR(500),"+
            "timestamp TIME,"+
            "PRIMARY KEY (username, timestamp),"+
            "FOREIGN KEY (username) REFERENCES account(username))"+
            "ENGINE=innodb;");
        System.out.println("posts table created.");

        stmt.executeUpdate("CREATE TABLE follows ("+
            "username_1 VARCHAR(32),"+
            "username_2 VARCHAR(32),"+
            "PRIMARY KEY (username_1, username_2),"+
            "FOREIGN KEY (username_1) REFERENCES account(username),"+
            "FOREIGN KEY (username_2) REFERENCES account(username))"+
            "ENGINE=innodb;");
        System.out.println("follows table created.");








        System.out.println("\nPopulating Tables...");   
        stmt.executeUpdate("INSERT INTO account VALUES" + 
        "('malialtunsoy', 'password', 'mali@mail.com'), " +
        "('daniel', 'password', 'daniel@mail.com'), " +
        "('mali', 'password', 'maliadmin@mail.com'), " +
        "('kutay', 'password', 'kutay@mail.com'), " +
        "('gizemkaral', 'password', 'gizem@mail.com'), " +
        "('gokberkboz', 'password', 'gokberk@mail.com'), " +
        "('irmakceliker', 'password', 'irmak@mail.com'); ");
        System.out.println("account Table Populated.");   

        stmt.executeUpdate("INSERT INTO user VALUES" + 
        "('malialtunsoy', 1000), " +
        "('kutay', 1000), " +
        "('gokberkboz', 1000), " +
        "('irmakceliker', 1000); ");
        System.out.println("user Table Populated.");   

        stmt.executeUpdate("INSERT INTO siteadmin VALUES" + 
        "('mali'); ");
        System.out.println("siteadmin Table Populated.");   

        stmt.executeUpdate("INSERT INTO coursecreator VALUES" + 
        "('daniel', 1000), " +
        "('gizemkaral', 500); ");
        System.out.println("coursecreator Table Populated.");

        stmt.executeUpdate("INSERT INTO course VALUES" + 
        "(1, 'Python Tutorial', 'This is a Python Course', 25, 'gizemkaral', 0), "+
        "(2, 'Web Design', 'This is a Web Design Course', 19, 'daniel', 1); ");
        System.out.println("course Table Populated.");

        stmt.executeUpdate("INSERT INTO lecture VALUES" + 
        "(10001, 'Loops', 1, 'Introduction to Loops', '_uQrJ0TkZlc' ,1), "+
        "(10002, 'Variables', 2, 'Introduction to Variables', '_uQrJ0TkZlc' ,1), "+
        "(10003, 'Data Types', 3, 'Introduction to Data Types', '_uQrJ0TkZlc' ,1), "+
        "(20001, 'Intro to PHP', 1, 'Introduction to PHP', 'C72WkcUZvco' ,2), " +
        "(20002, 'Intro to JS', 2, 'Introduction to JS', 'C72WkcUZvco' ,2); ");
        System.out.println("lecture Table Populated.");

        stmt.executeUpdate("INSERT INTO rating VALUES" + 
        "('malialtunsoy', 1, 4), "+
        "('gokberkboz', 2, 1);");
        System.out.println("rating Table Populated.");

        stmt.executeUpdate("INSERT INTO owns VALUES" + 
        "('malialtunsoy', 1), "+
        "('malialtunsoy', 2), "+
        "('gokberkboz', 2);");
        System.out.println("owns Table Populated.");

        stmt.executeUpdate("INSERT INTO watched VALUES" + 
        "('malialtunsoy', 10001), "+
        "('malialtunsoy', 10002), "+
        "('malialtunsoy', 10003), "+
        "('malialtunsoy', 20001), "+
        "('gokberkboz', 20001);");
        System.out.println("watched Table Populated.");

        stmt.executeUpdate("INSERT INTO announces VALUES" + 
        "(1, 'New Lecture', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', '12:00:00', 'gizemkaral'), "+
        "(1, 'Correction on Lecture 2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', '12:00:10', 'gizemkaral');");
        System.out.println("announces Table Populated.");

        stmt.executeUpdate("INSERT INTO notes VALUES" + 
        "('malialtunsoy', 10001, 'Very nice lecture.'), "+
        "('malialtunsoy', 10002, 'Topics between min 5-7 are important.');");
        System.out.println("notes Table Populated.");

        stmt.executeUpdate("INSERT INTO wishes VALUES" + 
        "('gokberkboz', 1), "+
        "('malialtunsoy', 2);");
        System.out.println("wishes Table Populated.");

        stmt.executeUpdate("INSERT INTO follows VALUES" + 
        "('malialtunsoy', 'malialtunsoy'), "+
        "('gokberkboz', 'gokberkboz'), "+
        "('irmakceliker', 'irmakceliker'), "+
        "('gizemkaral', 'gizemkaral'), "+
        "('daniel', 'daniel'), "+
        "('gokberkboz', 'irmakceliker'), "+
        "('malialtunsoy', 'gokberkboz'), "+
        "('malialtunsoy', 'gizemkaral'), "+
        "('gokberkboz', 'malialtunsoy'), "+
        "('malialtunsoy', 'irmakceliker');");
        System.out.println("follows Table Populated.");

        stmt.executeUpdate("INSERT INTO question VALUES" + 
        "(1, 'malialtunsoy', 'About loops?' ,'I cannot understand the second topic in the video. Can you explain again?', 'Hi, mali. The loops are very easy...', '12:15:32', '14:42:21'), "+
        "(1, 'malialtunsoy', 'About booleans?' ,'I cannot understand the second topic in the video. Can you explain again?', NULL, '12:59:32', NULL), "+
        "(1, 'gokberkboz', 'About variables?' ,'What do you mean by variables? Can you explain again?', 'Hi, GB. The variables are very easy...', '17:15:32', '21:42:21');");
        System.out.println("question Table Populated.");

        stmt.executeUpdate("INSERT INTO requestrefund VALUES" + 
        "('malialtunsoy', 1, 'Not English', 'I cannot understand the Mandarin Chinese', 'ACTIVE'),"+
        "('gokberkboz', 2, 'I dont like it', 'I want my money back.', 'ACTIVE');");
        System.out.println("requestrefund Table Populated.");

        /*stmt.executeUpdate("INSERT INTO discountoffer VALUES" + 
        "('mali', 'gizemkaral', 1, 6 ,'ACTIVE'),"+
        "('mali', 'daniel', 2, 9 ,'ACTIVE');");
        System.out.println("discountoffer Table Populated.");*/

        stmt.executeUpdate("INSERT INTO complaint VALUES" + 
        "('daniel', NULL, 2, 'Payment Problem', 'I cannot withdraw money from the system.', NULL),"+
        "('malialtunsoy', NULL, 1, 'Videos are Freezing', 'Videos are freezing while watching.', NULL);");
        System.out.println("complaint Table Populated.");

        stmt.executeUpdate("INSERT INTO posts VALUES" + 
        "('irmakceliker', 'I learned Java today', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '21:30:21'),"+
        "('gokberkboz', 'Im looking for a new python course.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit labore et dolore magna aliqua.', '12:15:54');");
        System.out.println("posts Table Populated.");

        stmt.executeUpdate("CREATE VIEW total_courses AS SELECT COUNT(course_id) AS total_count FROM course;");

        stmt.executeUpdate("ALTER TABLE discountoffer ADD CONSTRAINT status_chk CHECK (status IN ('ACTIVE','APPROVE','DECLINE'));");
        stmt.executeUpdate("ALTER TABLE requestrefund ADD CONSTRAINT refundstatus_chk CHECK (status IN ('ACTIVE','APPROVE','DECLINE'));");
        stmt.executeUpdate("ALTER TABLE course ADD CONSTRAINT discount_chk CHECK (discount_allow = 1 OR discount_allow = 0);");
        stmt.executeUpdate("ALTER TABLE user ADD CONSTRAINT balance_chk CHECK (balance > 0);");


        System.out.println("=====================================================ACCOUNT=====================================================");  
        System.out.printf("%12s |%12s |%12s \n", "username", "password", "email");
        System.out.println("--------------------------------------------------------------------------------------------------------------");
        ResultSet accounts = stmt.executeQuery("SELECT * FROM account");
        while(accounts.next()){
            System.out.printf("%12s |%12s |%12s\n", accounts.getString("username"), accounts.getString("password"), accounts.getString("email"));
        }

        /*System.out.println("\n\n====================COMPANY====================");  
        System.out.printf("%12s |%20s |%12s\n", "cid", "cname", "quota");
        System.out.println("-------------------------------------------------");
        ResultSet companies = stmt.executeQuery("SELECT * FROM company");
        while(companies.next()){
            System.out.printf("%12s |%20s |%12s\n", companies.getString("cid"), companies.getString("cname"), companies.getString("quota"));
        }

        System.out.println("\n\n==============APPLY==============");  
        System.out.printf("%12s |%12s\n", "sid", "cid");
        System.out.println("---------------------------------");
        ResultSet applies = stmt.executeQuery("SELECT * FROM apply");
        while(applies.next()){
            System.out.printf("%12s |%12s \n", applies.getString("sid"), applies.getString("cid"));
        }
		*/
    }
    catch(SQLException e){
        System.out.println("SQLException: " + e.getMessage());

    }

}

}


