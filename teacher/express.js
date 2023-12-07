const express = require('express');
const session = require('express-session');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const uid = window.localStorage.getItem("uid");

var conn = mysql.createConnection({
    host:'localhost', user:'root', password:'', database:'ojt_monitoring'
});

const app = express();
app.use(express.static('public'));
app.set('views', `${__dirname}/view`);
app.set('view engine', 'ejs');

app.use(bodyParser.urlencoded({extended: true}));
app.use(bodyParser.json());
app.use(session({secret: 'frogrammers',
                 resave: true, 
                 saveUninitialized: true
                }));

app.listen(8001, 'localhost');


app.post('/login', (req, res) => {
    req.session.userID = req.body.userID;
    req.session.fullName = 'John Doe'; 
    res.json(userID);
});


