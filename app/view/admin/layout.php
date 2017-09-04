<html>
<head>
 <meta charset="UTF-8">
<style>
* {
    box-sizing: border-box;
}
.row::after {
    content: "";
    clear: both;
    display: block;
}
[class*="col-"] {
    float: left;
    padding: 15px;
}
.footer {
    background-color: gray;
    color: #ffffff;
    text-align: center;
    font-size: 12px;
    padding: 15px;
}
/* For mobile phones: */
[class*="col-"] {
    width: 100%;
}
/* For desktop and tablets: */
@media only screen and (min-width: 600px) {
.col-1 {width: 8.33%;}
.col-2 {width: 16.66%;}
.col-3 {width: 25%;}
.col-4 {width: 33.33%;}
.col-5 {width: 41.66%;}
.col-6 {width: 50%;}
.col-7 {width: 58.33%;}
.col-8 {width: 66.66%;}
.col-9 {width: 75%;}
.col-10 {width: 83.33%;}
.col-11 {width: 91.66%;}
.col-12 {width: 100%;}
}

 html {
    font-family: "Lucida Sans", sans-serif;
}
.header {
    background-color: #9933cc;
    color: #ffffff;
    padding: 15px;
}
.menu ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
.menu li {
    margin-bottom: 7px;
    background-color :#33b5e5;
    color: #ffffff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}
.menu li:hover {
    background-color: #0099cc;
}
.menu li a {
    margin: 0;
    padding: 8px;
    display: block;
    text-decoration: none;
    color: white;
}
.add {
    display: inline-block;
    padding: 8px;
    background-color: green;
    color: white;
    text-align: center;
    text-decoration: none;
}
.add:hover {
    background-color: lightgreen;
}

</style>
</head>
<body>
<div class="header">
    <h1>Laboratorium Analityczne</h1>
</div>
<div class="row">
<div class="col-3 menu">
    <ul>
        <li>
            <a href="?cmd=admin-panel">Użytkownicy</a>
        </li>
        <li>
            <a href="?cmd=role-index">Konta i uprawnienia</a>
        </li>
        <li>
            <a href="?cmd=method-index">Metody badawcze</a>
        </li>
        </ul>
</div>
<div class="col-9">
    <?php echo $content;?>
</div>
</div>
<div class="footer">
    <p>Stopka</p>
</div>
</body>
</html>
