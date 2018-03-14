// Naz Taylor
// CS 316
// Project 2
// Portions of the findOption and child_process functions come from Paul Linton

// module initiation
var http = require('http');
var paul = require('/homes/paul/HTML/CS316/p2_req.js');
var fs = require('fs');

// Creation of server
var server = http.createServer(myprocess);
var host = paul.phost();
var logger = paul.logger;
const exec = require('child_process').exec;

const PORT = Math.floor(Math.random() * (paul.pend() - paul.pstart()) + paul.pstart());

// Funtion that takes the requested url and decides what type of file it is and calls the appropriate functions to serve that file.
function myprocess(request, response){
	var filename = request.url;
	filename = filename.substring(1);	
	var filetype = findOption(filename);
	
	// If it is an HTML file and the file exists in the corresponding directory
	if (filetype == 1 && fs.existsSync("./PUBLIC/" + filename) ){
		openHTML(response, filename);
		
	}

	// If it is a cgi file and the file exists in the corresponding directory
	else if (filetype == 2 && fs.existsSync("./CGIDIR/" + filename)){
		getCGI(response, filename);

	}

	// If it is neither type of file or it does not exist in the correspoinding directory 
	else {
	error404(response);
	}
	
}

// read and display the contents of the html file
function openHTML(response, filename){
	content = fs.readFileSync("./PUBLIC/" + filename );
	response.end(content);
}

// run and display the results of a cgi program
function getCGI(response, filename){
      	child_process(response, filename);
}

// determine whether the file specified in the url is a html, cgi or neither
function findOption(theUrl){
	fmatch = theUrl.match(/^[a-zA-Z0-9_]*.(html|cgi)$/);
	// if it is neither type
	if(fmatch == null){
		return 0;
	}
	else if(fmatch['index'] == 0){
		hmatch = theUrl.match(/^[a-zA-Z0-9_]*.html$/);
		// if it is a cgi file
		if (hmatch == null){
			return 2;
		}
		// if it is a html file
		else if (hmatch['index'] == 0){
			return 1;
		}	
	}
	return 100;
}

// error message to be given if something goes wrong
function error404(response){
	response.writeHead(404, {"Content-Type": "text/plain"})
	response.write("Error 404: Page not found.");
	response.end();
}

// listener to see what is being asked for
function mylisten(server, PORT, host, log){
	log(PORT, host);
	server.listen(PORT, host);
}

// if a cgi is called then this handles the execution and display of it
function child_process(response, filename) {
	response.writeHead(200, {"Content-Type": "text/plain"});
        exec(filename, {env: {'PATH': './CGIDIR'}}, function(error, stdout, stderr) {

                if (error) {
                        console.error('exec error'+error);
                        return;
                }
                response.end(stdout + stderr);
                
        });
	return 100;
}

// call to get the listener running
mylisten(server, PORT, host, logger);

