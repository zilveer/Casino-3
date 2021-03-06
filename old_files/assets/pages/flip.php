<div id="ModalAnim" class="modal fade" role="dialog" style="margin-top:30px;">
<div class="modal-dialog">
<div class="modal-content" style="border:0; border-radius:0;">
<div class="modal-body" style="overflow:none; min-height:240px;">

<center>

<img src="coinflip.gif" style="width:100%;">

</center>

</div>
</div>
</div>
</div>

<div id="modalForMsg" class="modal fade" role="dialog">
<div class="modal-dialog">

<?php

$server_seed = loadAccDetails("user_id",$_SESSION['user_id'],"server_seed");
$server_seed_hash = loadAccDetails("user_id",$_SESSION['user_id'],"server_seed_hash");

if($server_seed == "" OR $server_seed_hash == "") {
	
$server_seed = md5(bin2hex(openssl_random_pseudo_bytes(8)));
$server_seed_hash = hash("sha512",$server_seed);

mysqli_query($con,"UPDATE users SET server_seed = '{$server_seed}', server_seed_hash = '{$server_seed_hash}' WHERE user_id = {$_SESSION['user_id']}");

}

?>

<div class="modal-content" style="overflow:none;">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Provably Fair</h4>
</div>
<div class="modal-body" id="modal_msg" style="overflow:none;">

Have you been wondering if this game is a scam or a legit one? Let's get it straight: <b>we're legit and we can prove it</b>.

<br>
<br>

This game can be proved fair, this means that we cannot choose a number in our favour. Your seeds for this session/round are below:

<br>
<br>

<b>Server Seed Hash: </b> <pre id="server_seed_hash_read"><?php echo $server_seed_hash; ?></pre>
<br>
<b>Client Seed: </b> <pre id="client_seed_read"></pre>
<br>
<b>Nonce: </b> <pre id="nonce_read"></pre>

<br>

<b><a href="verify">You can always verify your rolls here.</a></b>

<br>
<br>

<b>Process to Validate:</b>

<br>
<br>

<ul>

<li>First of all, obtain your seeds for the old round by clicking on <b>History</b>.</li>

<li>Create two strings:

<br>
<br>

$string1 = NONCE . ":" . SERVER_SEED . ":" . NONCE;
<br>
$string2 = NONCE . ":" . CLIENT_SEED . ":" . NONCE;

<br>
<br></li>

<li>Obtain a HMAC-SHA512 hash by hashing the <b>first string ($string1)</b> with the key <b>second string ($string2)</b>.

<li>Take the first 8 characters of the hexdecimal, and convert them to decimal.</li>

<li>Divide this decimal with <b>429496.7295</b> and round it to nearest whole number.</li>

<li>Your roll number is obtained, and it cannot be more than 10,000.</li>

<li>If you obtain any number betweem 0 and 4999, it means that the coin face was head.</li>

<li>If you obtain any number betweem 5000 and 9999, it means that the coin face was tail.</li>

<li>If you obtain any number 10000, it means that the house won. Bad luck, perhaps?</li>

</li>

</ul>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location = 'verify';">Verify Results</button> &nbsp; <button type="button" class="btn btn-default" data-dismiss="modal">Enough Said</button>
</div>
</div>

</div>
</div>

<section id="form-page">

<div class="container">
<div class="row">

<div class="col-md-12" >
<div class="panel panel-default" id="duh">
<div class="panel-body">

<center>

<span style="font-size:58px;"><b>Coin Flip</b></span>

<br>
<br>

<a href="history?id=6" class="btn btn-sm btn-success">History</a> &nbsp; <a onclick="proveFair();" class="btn btn-sm btn-success">Provably Fair</a>

<script>

function proveFair() {

$("#modalForMsg").modal("show");	
	
}

</script>

<br>
<br>

<p style="font-size:18px;">Increase your Bitcoins by flipping coins.</p>

</center>

<br>
<br>

<div id="message_holder">



</div>

<div class="row" style="padding-bottom:40px;">

<div class="col-xs-6 col-lg-6">
<center>
<img src="assets/images/heads.svg" id="head-img" class="pull-right" onclick="setFace('head');">
</center>
</div>

<div class="col-xs-6 col-lg-6">
<center>
<img src="assets/images/tails.svg" id="tail-img" class="pull-left" style="opacity:0.5" onclick="setFace('tail');">
</center>
</div>

</div>

<div class="row">
<div class="col-sm-12 col-lg-8 col-lg-offset-2 col-md-offset-2">
<center>
<div class="input-group text-center">
<span id="minbtn" class="input-group-addon" style="margin-right:3px;" onclick="setAmount('min');"><i class="fa fa-arrow-down"></i> Min</span>
<input type="text" class="form-control" id="bet_field" value="<?php echo $minimum_bet = settings("coinFlip_minBet"); ?>" onchange="validateBetAmt();" onkeyup="validateBetAmt();">
<span id="maxbtn" class="input-group-addon" onclick="setAmount('max');"><i class="fa fa-arrow-up"></i> Max</span>
</div>
</center>
</div>
</div>

<br>

<div class="row">
<div class="col-sm-12 col-lg-6 center-block">
<div class="btn btn-group-justified">
<center>
<button type="button" class="btn btn-primary btn-lg" id="bet-btn" style="width:100%; background:#90b0e5; font-size:135%;" onclick="flipCoin();">Flip Coin</button>
</center>
</div>
</center>
</div>
</div>

<br>
<br>

<style>

.center-block {
	
float:none;
	
}

#head-img, #tail-img {
  cursor: pointer;
  transition: 0.3s ease;
  -webkit-transition: 0.3s ease;
  -moz-transition: 0.3s ease;
  -o-transition: 0.3s ease;
  width:35%;
}

#head-img:hover, #tail-img:hover {
  opacity: 0.7 !important;
}

</style>

<center>
<small>
You have selected <b id="choice">heads</b>.
<br>
Guess heads or tails to win <?php echo(settings('CoinFlipReturn') - 100); ?>% instantly!
</small>
</center>

</div>

</div>
</div>

</div>
</div>

</section>

<input type="hidden" id="bet_face" value="head">
<input type="hidden" id="client_seed">
<input type="hidden" id="nonce">
<input type="hidden" id="server_seed_hash" value="<?php echo $server_seed_hash; ?>">

<script>

function setFace(face) {
	
if(face == "head") {
	
document.getElementById("head-img").style = "opacity:1;";	
document.getElementById("tail-img").style = "opacity:0.5;";	
document.getElementById("bet_face").value = face;	
document.getElementById("choice").innerHTML = 'heads';	
	
} else {
	
document.getElementById("head-img").style = "opacity:0.5;";	
document.getElementById("tail-img").style = "opacity:1;";	
document.getElementById("bet_face").value = face;
document.getElementById("choice").innerHTML = 'tails';	
	
}	
	
}

function setupClientSide() {
	
function randomString(length, chars) {

    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;

}

var http = new XMLHttpRequest();
var url = "programmer?method=get_server_hash";
var params = "";
http.open("POST", url, true);

http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

http.onreadystatechange = function() {

if(http.readyState == 4 && http.status == 200) {

gotten_hash = http.responseText;
document.getElementById("server_seed_hash").innerHTML = gotten_hash;	
document.getElementById("server_seed_hash_read").innerHTML = gotten_hash;	

}

}

http.send(params);

nonce_gen = Math.floor(Math.random() * 10);
client_seed_gen = randomString(16, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

document.getElementById("client_seed").value = client_seed_gen;
document.getElementById("nonce").value = nonce_gen;

document.getElementById("nonce_read").innerHTML = nonce_gen;
document.getElementById("client_seed_read").innerHTML = client_seed_gen;	
	
}

function flipCoin() {
	
$("#ModalAnim").modal("show");
document.getElementById('bet-btn').disabled = "disabled";	

var birdSound = new Audio('flip.mp3');
birdSound.loop = false;
birdSound.play();

setTimeout(function() {
	
var http = new XMLHttpRequest();
var url = "ajax?method=flip_coin";
var params = "bet_amount="+document.getElementById("bet_field").value+"&bet_face="+document.getElementById("bet_face").value+"&client_seed="+document.getElementById("client_seed").value+"&nonce="+document.getElementById("nonce").value;
http.open("POST", url, true);

http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

http.onreadystatechange = function() {

if(http.readyState == 4 && http.status == 200) {

var obj = $.parseJSON(http.responseText);

document.getElementById("balance_global").innerHTML = obj.new_balance;

if(obj.error == "") {

if(obj.win == 1) {

document.getElementById('message_holder').innerHTML = '<div class="alert alert-success">'+obj.message+'</div>';	

} else {

document.getElementById('message_holder').innerHTML = '<div class="alert alert-danger">'+obj.message+'</div>';						

}

} else {

document.getElementById('message_holder').innerHTML = '<div class="alert alert-danger">'+obj.error+'</div>';	

}

setupClientSide();
$("#ModalAnim").modal("hide");
document.getElementById('bet-btn').disabled = "";		

}

}

http.send(params);

},2000);

setTimeout(function() {
	
$("#ModalAnim").modal("hide");
	
},4000);

}

function validateBetAmt() {
	
var val = document.getElementById("bet_field").value;

if(isNaN(val) == true) {
	
document.getElementById("bet_field").value = <?php echo $minimum_bet; ?>;
	
} else if(val == 0) {

	
	
} else if(val < <?php echo $minimum_bet; ?>) {
	
document.getElementById("bet_field").value = <?php echo $minimum_bet; ?>;
	
} else if(val > <?php echo $maximum_bet = settings("coinFlip_maxBet"); ?>) {
	
document.getElementById("bet_field").value = <?php echo $maximum_bet; ?>;
	
}	
	
}

function setAmount(type) {
	
if(type == "min") {
	
document.getElementById("bet_field").value = <?php echo $minimum_bet; ?>;
	
} else {
	
var balance = document.getElementById("balance_global").innerHTML;
	
if(balance < <?php echo $maximum_bet; ?>) {
	
var max_amt = balance;	
	
} else {
	
var max_amt = <?php echo $maximum_bet; ?>;
	
}
	
document.getElementById("bet_field").value = max_amt;
	
}	
	
}

setupClientSide();

</script>