const express = require('express');
const router = express.Router();
const mysql = require('mysql');

var db = mysql.createConnection({
    host:'localhost', user:'root', password:'', database:'ojt_monitoring'
});



app.post('/login', (req, res) => {
    req.session.userID = req.body.userID;
    const statement = db.prepare("SELECT firstName, lastName FROM student WHERE userId = ?");
    
    statement.bind_param("i", userId);
    statement.execute();
    const result = statement.get_result();
    
    if (result.num_rows > 0) {
        const row = result.fetch_assoc();
        const fullName = row.firstName + ' ' + row.lastName;
        res.render('index', { fullName });
    } else {
        res.render('index', { fullName: "No data found" });
    }
    
    statement.close();
});


module.exports = router;