<?php
require_once("top.php");
?>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<?php
$OUTPUT->bodyStart();
?>
<div id="container">
 <a name="index">
 <div id="page1" class="jumbotron">
    <a name="index"></a>
<h1>Welcome to 
<?php
if ( strlen($CFG->servicename) > 0 ) {
    echo(htmlentities($CFG->servicename));
} else {
    echo('Test Tsugi Server');
}
echo("</h1>\n");

echo('<p><a href="tsugi">Go to the Tsugi Dashboard</a></p>'."\n");
if ( $CFG->hasSiteLessons() ) {
echo('<p><a href="lessons">View Lessons</a></p>'."\n");
echo('<p><a href="tsugi/cc/">Get a Common Cartridge</a></p>'."\n");
}

if ( strlen($CFG->ownername) > 0 ) {
    echo("<p>Please contact ". $CFG->ownername." for questions about this server</p>\n");
}
?>
<p>For questions about TsugiCloud services, please contact
info at learnxp.com.
</p>

</div>
</div>

<?php
$OUTPUT->footerStart();
?>
<script>
$('body').prepend('<img src="images/bgbg.jpg" onload="this.style.opacity=\'1\';" \
  style=" z-index: -1000; position: fixed; top:-10%; height: 110%; width: 100%; \
   opacity:0; -moz-transition: opacity 2s; -webkit-transition: opacity 2s; \
  -o-transition: opacity 2s; transition: opacity 2s; \
">');
</script>
<?php
$OUTPUT->footerEnd();
?>
