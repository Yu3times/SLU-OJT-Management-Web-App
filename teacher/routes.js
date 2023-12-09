const express = require('express');
const session = require('express-session');
const router = express.Router();
const mysql = require('mysql');

var db = mysql.createConnection({
    host:'localhost', user:'root', password:'', database:'ojt_monitoring'
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
    //TODO: handle session
};

router.post('/login', (req, res) => {
    const userId = req.body.userID;
    
    req.session.userID = req.body.userID;
    const statement = db.prepare("SELECT firstName, lastName FROM student WHERE userId = ?");
    
    statement.bind_param("i", userId);
    statement.execute();
    const result = statement.get_result();
    
    if (result.num_rows > 0) {
        const row = result.fetch_assoc();
        const fullName = row.firstName + ' ' + row.lastName;
        console.log('FullName:', fullName);
        res.render('index.ejs', {fullName});
    } else {
        res.render('index.ejs', { fullName: "No data found" });
    }
    
    statement.close();
});


module.exports = router;