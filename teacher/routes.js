const express = require('express');
const session = require('express-session');
const router = express.Router();
const mysql = require('mysql');

var db = mysql.createConnection({
    host: 'localhost', user: 'root', password: '', database: 'ojt_monitoring'
});

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

router.get('/homepage', (req, res) => {
    const userId = req.query.teacherUserId;

    const statement = "SELECT firstName, lastName FROM teacher WHERE userId = ?";
    
    db.query(statement, [userId], (error, result) => {
        if (error) {
            console.error('Error executing query:', error);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        if (result.length !== 0) {
            const row = result[0];
            const fullName = row.firstName + ' ' + row.lastName;
            console.log('FullName:', fullName);
            res.render('homepage', { fullName: fullName,  teacherUserId: req.query.teacherUserId});
        } else {
            res.render('homepage', { fullName: "No data found",  teacherUserId: req.query.teacherUserId });
        }
    });
});

module.exports = router;
