<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>New Website</title>
	<link rel="stylesheet" href="style.css" />

<style type="text/css">
		*{margin:0;padding:0}
img {
    width:100%;
}
.header_wraper {
    width:  1170px;
	margin:0 auto;
}
/*
.logo_sec {
    width: 1170px;
	overflow:hidden;
	height:150px;
}

.logo {
    width:300px;
    float:left;
	overflow:hidden;
}

.logo img{
	height:150px;
	
}

.add {
    width:800px;
    float:right;
	overflow:hidden;
}
.add img{
	height:150px;
}*/
.nav{
	border-bottom:3px solid #7ACDC8;
	background:#4a5d80;
}
.nav ul {
	list-style-type:none;
	padding:10px;
	background:#4a5d80;
	overflow:hidden;
	
}
.nav ul li{
	float:left;
	margin:0px 10px;
}
.nav ul li a{
	text-decoration:none;
	color:white;
	padding:5px;
}
.nav ul li a:hover{
	background: #5c6d8e;
	transition: .3s ease;
}
.main_con{
	min-height: 500px;
	border:3px solid #4a5d80;
	margin: 5px 0;
	padding: 10px;
	font-size: 20px;
}
.con_wraper{
	width: 1170px;
	margin: 0 auto;
}
.footer_wraper{
    width: 1170px;
    margin: 0 auto;
}
/*
div.footer_con{
	background:#8197bf;
	height:300px;
	border-bottom:2px solid black;
}
*/
div.copyright{
	background:#4A5D80;
}

div.copyright p{
	text-align:center;
	padding:10px;
	font-size:18px;
}

</style>

</head>
<body>
	<div class="main_wraper"> 
		<div class="header_wraper"> 
			<div class="logo_sec"> 
				<div class="logo">
					<!--//logo here-->
				</div>
				<div class="add">
					
				</div>
			</div>
			 
			<div class="nav"> 

				<h1 style="text-align: center;">Own mvc Tutorial</h1>


				<!--
				<ul>
					<li><a href="#">Home</a></li>
					<li><a href="#">Blog</a></li>
					<li><a href="#">Protfolio</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
			-->
			</div>
		</div>
		
		
		<div class="con_wraper">
			<div class="main_con">
				

				Category List By ID <hr/>
				<?php
				foreach($catbyid as $value){
					echo $value['name']."<br/>";
				}


				?>



			</div>	
		</div>


		<div class="footer_wraper"> 
			<div class="footer_con"> 
				
			</div>
			<div class="copyright"> 
				<p>&copy;All coprrights Reserved By Md Towheed</p>
			</div>
		</div>
		
		
	</div>
	
</body>
</html>