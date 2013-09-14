/* Colour palette from: http://www.colourlovers.com/palette/623761/Walking_Away */

define(`KEY', `185, 5, 4')
define(`BG_DARK', `232, 232, 232')
define(`BG_LIGHT', `246, 246, 246')
define(`MENU', `51, 51, 51')

body {
	margin: 0px;
	padding: 0px;
	font-size: 16px;
	font-family: sans-serif;
	background-color: rgba(BG_DARK, 0.7);
	background-image: url('../res/bg.png');
}

h2 {
	margin: 4px;
	padding: 3px 0px;
	font-size: 1em;
	color: rgba(MENU, 1);
	float: left;
	cursor: default;
}

hr {
	border: 0;
	height: 0;
	border-top: 1px solid rgba(0, 0, 0, 0.1);
	border-bottom: 1px solid rgba(255, 255, 255, 0.5);
	margin: 20px;
}

input[type=text],
textarea {
	margin: 4px;
	padding: 3px;
	clear: both;
	width: 99%;
	background-color: rgba(255, 255, 255, 0.7);
	border: 1px solid rgba(0, 0, 0, 0.15);
	border-radius: 4px;
	box-sizing: border-box;
	display: block;
	outline: none;
	font-family: "Lucida Console", monospace;
	font-size: 0.9em;
}

textarea {
	resize: none;
	height: 50px;
}

input[type=text]:focus,
textarea:focus {
	border-color: #b9b9b9;
}

input[type=submit] {
	margin: 4px;
	padding: 3px;
	background-color: rgba(0, 0, 0, 0.05);
	border-radius: 4px;
	border: 1px solid rgba(0, 0, 0, 0.15);
	overflow: auto;
	cursor: default;
	width: 150px;
	font-size: inherit;
	float: right;
}

input[type=submit]:hover {
	border-color: rgba(0, 0, 0, 0.25);
}

input[type=submit]:active {
	background-color: rgba(0, 0, 0, 0.1);
}

span.clear {
	clear: both;
	display: block;
}

#menu a {
	display: inline;
	font-size: 1.4em;
	font-weight: bold;
	text-decoration: none;
	margin-right: 30px;
	margin-bottom: 0px;
	padding: 5px;
	color: rgba(MENU, 1);
	outline: none;
}

#menu a:hover {
	color: rgba(KEY, 1);
}

#menu a:target {
	color: rgba(KEY, 1);
	text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.7);
}

#menu {
	width: 800px;
	margin: auto;
	padding: 10px;
}

.page {
	border: 1px solid rgba(0, 0, 0, 0.3);
	border-radius: 10px;
	width: 800px;
	margin: auto;
	padding: 20px 10px;
	background-color: rgba(BG_LIGHT, 1);;
	background-image: url('../res/bg2.png');
}

.products {
	margin: 4px;
	border: 1px solid rgba(0, 0, 0, 0.15);
	border-radius: 4px;
	clear: both;
	padding: 5px;
}

label.cb-button input {
	display: none;
}

label.cb-button input + span {
	margin: 4px;
	padding: 0px 10px;
	border: 1px solid rgba(0, 0, 0, 0.15);
	border-radius: 4px;
	background-color: rgba(0, 0, 0, 0.05);
	text-align: center;
	line-height: 25px;
	vertical-align: middle;
	display: block;
	cursor: default;
	float: left;
}

label.cb-button input + span:hover {
	border-color: rgba(0, 0, 0, 0.25);
}

label.cb-button input:checked + span {
	border-color: rgba(KEY, 0.6);
	box-shadow: 0px 0px 3px rgba(KEY, 1);
}

.cb-release {
	margin-left: 15px;
	padding: 0px 3px;
	font-size: 0.7em;
	line-height: 25px;
	vertical-align: middle;
	border: 1px solid rgba(KEY, 0.6);
	border-radius: 3px;
	background-color: rgba(KEY, 0.6);
	color: #fff;
}

#log-text {
	margin: 4px;
	padding: 3px;
	clear: both;
	width: 99%;
	border: 1px solid rgba(0, 0, 0, 0.15);
	border-radius: 4px;
	box-sizing: border-box;
	overflow: auto;
	background-color: #fff;
	font-family: "Lucida Console", monospace;
	font-size: 0.9em;
}

.error {
	border-color: red;
	box-shadow: 0 0 3px red;
}

#footer {
	color: rgba(0, 0, 0, 0.3);
	text-align: center;
	font-size: 0.9em;
	text-shadow: 1px 1px 0px rgba(255, 255, 255, 0.8);
	text-decoration: none;
	cursor: default;
	margin: 15px auto;
	width: 800px;
}

#footer a {
	color: rgba(0, 0, 0, 0.3);
	text-decoration: none;
}

#footer a:hover {
	color: rgba(KEY, 1);
}

::selection {
	background-color: #5af;
	color: #fff;
	text-shadow: none;
};
