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
    req.session.userID = userId;
    req.session.password = password;

    const statement = "SELECT firstName, lastName FROM user natural join teacher WHERE teacherId = ? AND password = ?";
    
    db.query(statement, [userId, password], (error, result) => {
        if (error) {
            console.error('Error executing query:', error);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        if (result.length > 0) {
            res.redirect("/homepage");
        } else {
            res.redirect('http://localhost:8080/ojt-web-project/login/loginPage.php');
        }
    });
});

router.get('/homepage', (req, res) => {

    console.log("connect to /homepage");
    if (req.session.userID) {
    const statement = "SELECT firstName, lastName FROM user natural join teacher WHERE userId = ? AND password = ?";
    
    db.query(statement, [req.session.userID, req.session.password], (error, result) => {
        if (error) {
            console.error('Error executing query:', error);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        if (result.length > 0) {
            const row = result[0];
            const fullName = row.firstName + ' ' + row.lastName;
            console.log('FullName:', fullName);
            res.render('homepage', { fullName: fullName,  teacherUserId: req.session.userID});
            } 
        });
    } else {
        res.redirect("logout");
    }
});

router.get('/logout', (req, res) => {
    console.log("connect to /logout");
    req.session.destroy();
    res.redirect("http://localhost:8080/ojt-web-project/login/loginPage.php");
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

module.exports = router;
