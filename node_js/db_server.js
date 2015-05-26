var mongoose = require('mongoose');
var mongourl = "mongodb://localhost:27017/mongoData";
//mongoose.connect(mongourl);

var db = mongoose.connect(mongourl).connection;

db.on('error', function(err){
	console.log("Connection error: ", err);
});
db.on('open', function(){
    console.log("Mongodb connected!");
    //Create schema and models here...
    var schema = mongoose.Schema;
    var userSchema = new schema({
        username: String,
        password: String,
        first_name: String,
        email_id: String,
        createdOn: Date,
        UpdatedOn: Date
    });
    
    var User = mongoose.model("User", userSchema);
    
    var Saroj = new User({
        username: "sarojsingh",
        password: "e10adc3949ba59abbe56e057f20f883e",
        first_name: "Saroj",
        email_id: "saroj@evon.com"
    });
    console.log("Data saved!");
    Saroj.save(function(err, data){
        if(err) console.log(err);
        else console.log('Saved: ', data);
    });
    
});

db.User.find();


