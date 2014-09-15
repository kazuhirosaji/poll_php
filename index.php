<?php

require_once('config.php');
require_once('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	// 投稿前

	// for CSRF
	if (!isset($_SESSION['token'])) {
		$_SESSION['token'] = sha1(uniqid(mt_rand(), true));
	}
} else {
	// 投稿後
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>投票システム</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<style>
	.selected {
		border:4px solid red;
	}
	</style>
</head>
<body>
<h1>お料理コンテスト</h1>
<form action="" method="POST">
	<img src="photo1.jpg", class="candidate", data-id="1">
	<img src="photo2.jpg", class="candidate", data-id="2">
	<img src="photo3.jpg", class="candidate", data-id="3">
	<img src="photo4.jpg", class="candidate", data-id="4">
	<p><input type="submit" value="投票する！"></p>
	<input type="hidden" id="answer" name="answer" value="">
	<input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
</form>
<script>
$(function() {
	$('.candidate').click(function() {
		$('.candidate').removeClass('selected');
		$(this).addClass('selected');
		$('#answer').val($(this).data('id'));
	});
});
</script>
</body>