<html>
<head>
 <meta charset="UTF-8">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="app/view/js/datepicker-pl.js"></script>
<script>
$(document).ready(function() {
  $('.datepicker').datepicker({
    dateFormat: 'yy-mm-dd',
    startDate: '-3d'
  });
});
function removeClassAttribute(id) {
    id.removeAttribute("class");
}
</script>
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
    margin: 0 0 15px 0;
    border-radius: 6px;
}

.delete, .edit {
    display: inline-block;
    padding: 3px;
    margin: 0;
    color: white;
    font-size: 12px;
    text-align: center;
    text-decoration: none;
    border-radius: 6px;
}
.delete:hover {
    background-color: #ff5050;
}
.delete {
    background-color: red;
    margin-left: 4px;
}
.edit:hover {
    background-color: #0099ff;
}
.edit {
    background-color: blue;
}
.add:hover {
    background-color: #00cc00;
}
.alert {
    padding: 15px;
    background-color: #f44336;
    color: white;
    border-radius: 10px;
    font-weight: bold;
}

.alert.success {
    background-color: #4CAF50;
    border: 3px solid green;
}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 26px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
.list_table {
    border-collapse: collapse;
    font-size: 13px;
}
.list_table th, .feature {
    margin: 0;
    padding: 0 5px;
    border: 1px solid black;
}
.feature {
    cursor: pointer;
}
.input_error {
    border: 1px solid red;
}
</style>
</head>
<body>
<div class="header" style="position: relative">
    <h1>Laboratorium Analityczne</h1>
    <h4 style="position: absolute; right: 15px; bottom: -8px">
    <?php if ($userH) {
        echo $userH->getFirstName().' '.$userH->getLastName().
        ' <a href="?cmd=login-logout">( Wyloguj )</a>';
    } ?>
    </h4>
</div>
<div class="row">
<div class="col-3 menu">
    <ul>
        <?php foreach ($menu as $cmd => $text) {
        echo '<li>';
        echo '<a href="?cmd='.$cmd.'">'.$text.'</a>';
        echo '</li>';
        }?>
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
