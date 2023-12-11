const express = require('express');
const session = require('express-session');
const bodyParser = require('body-parser');
const router = express.Router();
const mysql = require('mysql');

var db = mysql.createConnection({
    host: 'localhost', user: 'root', password: '', database: 'ojt_monitoring'
});

router.use(express.static('${__dirname}../public'));
router.use(bodyParser.urlencoded({extended: true}));
router.use(bodyParser.json());
router.use(session({
    secret: 'frogrammers',
    resave: false,
    saveUninitialized: true
}));

const noCacheMiddleware = (req, res, next) => {
    res.header('Cache-Control', 'private, no-cache, no-store, must-revalidate');
    res.header('Expires', '-1');
    res.header('Pragma', 'no-cache');
    next();
};

router.use(noCacheMiddleware);

const requireLogin = (req, res, next) => {
    if (!req.session.userId) {
        return res.send('<script>window.location.href="/login/loginPage.php";</script>');
    }
    next();
};
router.post('/login', (req, res) => {
    console.log("connect to /login");
    const userId = req.body.userID;
    const password = req.body.password;

    const statement = "SELECT firstName, lastName, userId FROM user natural join teacher WHERE teacherId = ? AND password = ?";
    
    db.query(statement, [userId, password], (error, result) => {
        if (error) {
            console.error('Error executing query:', error);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        if (result.length > 0) {
            req.session.userID = result[0].userId;
            res.redirect("/homepage");
        } else {
            res.redirect('http://localhost/ojt-web-project/login/loginPage.php');
        }
    });
});

router.get('/homepage', (req, res) => {
    console.log("connect to /homepage");
    
    if (req.session.userID) {
        const userId = req.session.userID;
        console.log(userId);
        const getTeacherNameQuery = "SELECT firstName, lastName, teacherId FROM user JOIN teacher ON user.userId = teacher.userId WHERE user.userId = ?";

        const getStudentsQuery = "SELECT student.studentId, CONCAT(student.firstName, ' ', student.lastName) AS fullName, user.email FROM student JOIN user ON student.userId = user.userId JOIN internship ON student.studentId = internship.studentId WHERE internship.teacherId = ?";

        db.query(getTeacherNameQuery, [userId], (error, teacherResult) => {
            if (error) {
                console.error('Error executing query to get teacher name:', error);
                res.status(500).json({ error: 'Internal Server Error' });
                return;
            }
            console.log(teacherResult);

            if (teacherResult.length > 0) {
                const teacherRow = teacherResult[0];
                const fullName = teacherRow.firstName + ' ' + teacherRow.lastName;

                console.log(fullName);
                const teacherId = teacherRow.teacherId;
                console.log(teacherId);
                db.query(getStudentsQuery, [teacherId], (studentError, studentResult) => {
                    if (studentError) {
                        console.error('Error executing query to get students:', studentError);
                        res.status(500).json({ error: 'Internal Server Error' });
                        return;
                    }
                    console.log(studentResult);

                    res.render('homepage', { fullName: fullName, teacherUserId: teacherId, students: studentResult });
                });
            }
        });
    } else {
        res.redirect("logout");
    }
});


router.get('/logout', (req, res) => {
    // Remove port number
    console.log("connect to /logout");
    req.session.destroy();
    res.redirect("http://localhost/ojt-web-project/login/loginPage.php");
});

router.post('/change-password', (req, res) => {
    console.log("connect to /change-password");
    const statement = "UPDATE user set password = ? WHERE userId = ?";
    db.query(statement, [req.body.password, req.session.userID], (error, result) => {
        if (error) {
            console.error('Error executing query:', error);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        } else {
            console.log("Changed password");
        }
    });
    res.redirect("/profile");
});

router.get('/profile', (req, res) => {
    console.log("connect to /profile");
    if (req.session.userID) {
        const statement = "SELECT * FROM user NATURAL JOIN teacher WHERE userId = ?";
        db.query(statement, [req.session.userID], (error, result) => {
        if (error) {
            console.error('Error executing query:', error);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        } else if (result.length > 0) {
            const row = result[0];
            res.render("profile", {
                firstName: row.firstName,
                lastName: row.lastName,
                password: row.password,
                email: row.email,
                teacherId: row.teacherId
            });
        }});
    } else {
        res.redirect('logout');
    }
});

router.get('/company-details', (req, res) => {
    console.log("connect to /company-details");
    if (req.session.userID) {
        const userQuery = "SELECT * FROM teacher WHERE userId = ?";
        const companyDetailsQuery = "SELECT * FROM company";
        db.query(userQuery, [req.session.userID], (error, teacherResult) => {
            if (error) {
                console.error('Error executing query:', error);
                res.status(500).json({ error: 'Internal Server Error' });
                return;
            } else {
                console.log("User Result:", teacherResult);
                console.log("User ID from session:", req.session.userID);
                console.log("First Name:", teacherResult[0].firstName);
                console.log("Last Name:", teacherResult[0].lastName);
                db.query(companyDetailsQuery, (error, companies) => {
                    if (error) {
                        console.error('Error executing query:', error);
                        res.status(500).json({ error: 'Internal Server Error' });
                        return;
                    } else {
                        res.render("company-details", {
                            firstName: teacherResult[0].firstName,
                            lastName: teacherResult[0].lastName,
                            companies: companies 
                        });
                    }
                });
            }
        });
    } else {
        res.redirect('logout');
    }
});


router.post('/submit-announcement', (req, res) => {
    const { teacherId, title, message } = req.body;
  
    const insertAnnouncementQuery = 'INSERT INTO announcements (teacherId, title, message) VALUES (?, ?, ?)';
  
    db.query(insertAnnouncementQuery, [teacherId, title, message], (error, result) => {
      if (error) {
        console.error('Error executing query to insert announcement:', error);
        res.status(500).json({ error: 'Internal Server Error' });
        return;
      }
  
      console.log('Announcement inserted successfully.');
      res.json({ success: true });
    });
  });

module.exports = router;
