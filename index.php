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
	if (empty($_POST['token']) || $_POST['token'] != $_SESSION['token']) {
		echo "unpermitted operation!";
	}
	// error check
	if (!in_array($_POST['answer'], array(1, 2, 3, 4))) {
		$err = "Please select picture";
	}

	if (empty($err)) {
		$dbh = connectDb();
		$sql = "insert into answers
				(answer, remote_addr, user_agent, answer_date, created, modified)
				values
				(:answer, :remote_addr, :user_agent, :answer_date, now(), now())";
		$stmt = $dbh->prepare($sql);
		$params = array(
			":answer" => $_POST['answer'],
			":remote_addr" => $_SERVER['REMOTE_ADDR'],
			":user_agent" => $_SERVER['HTTP_USER_AGENT'],
			":answer_date" => date("Y-m-d")
			);

		if ($stmt->execute($params)) {
			$msg = "投票ありがとうございました!";
		} else {
			$err = "投票は1日1回までです";
		}
	}
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
<?php if (!empty($msg)) : ?>
	<p style="color:green"><?php echo h($msg); ?></p>
<?php endif; ?>
<?php if (!empty($err)) : ?>
	<p style="color:red"><?php echo h($err); ?></p>
<?php endif; ?>
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
<p><a href="result.php">投票結果を見る</a></p>
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