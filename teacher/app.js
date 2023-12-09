const express = require('express');
const session = require('express-session');
const bodyParser = require('body-parser');
const app = express();
const routes = require('./routes');

app.use(express.static('public'));
app.set('views', `${__dirname}/view`);
app.set('view engine', 'ejs');

app.use(bodyParser.urlencoded({extended: true}));
app.use(bodyParser.json());
app.use(session({secret: 'frogrammers',
                 resave: true, 
                 saveUninitialized: true
                }));

app.use('/', routes);

const PORT = process.env.PORT || 8001;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
