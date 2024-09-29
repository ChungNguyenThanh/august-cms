<!DOCTYPE html>
<html><head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Install August CMS</title>
</head>

<?php
$step = 1;
if (isset($_REQUEST["submit"]) && isset($_REQUEST["step"]) && ($_REQUEST["step"] == 1)) {
	$str = "";
	$file = fopen($_SERVER["DOCUMENT_ROOT"] . "/.env", "r");
	if ($file) {
		while(!feof($file)) {
			$line = fgets($file);
			
			if (trim($line) == '# DB_DATABASE=laravel') {
				$str .= 'DB_DATABASE='.$_REQUEST['database']."\n";
			} elseif (trim($line) == '# DB_USERNAME=root') {
				$str .= 'DB_USERNAME='.$_REQUEST['user']."\n";
			} elseif (trim($line) == '# DB_PASSWORD=') {
				$str .= 'DB_PASSWORD='.$_REQUEST['pwd']."\n";
			} else {
				$str .= $line;
			}
		}
		fclose($file);
	}

	$file = fopen($_SERVER["DOCUMENT_ROOT"] . "/.env", "w");
	if ($file) {
		fwrite($file, $str);
		fclose($file);
	}

	$step = 2;
} elseif (isset($_REQUEST["submit"]) && isset($_REQUEST["step"]) && ($_REQUEST["step"] == 2)) {
	// UserSeeder
	$str = "";
	$file = fopen($_SERVER["DOCUMENT_ROOT"] . "/packages/august/database/seeders/UserSeeder.php", "r");
	$file_bk = fopen($_SERVER["DOCUMENT_ROOT"] . "/packages/august/database/seeders/UserSeeder_bk.php", "w");
	if ($file) {
		while(!feof($file)) {
			$line = fgets($file);

			if (trim($line) == 'const USER_EMAIL = "superadmin@gmail.com";') {
				$line = '    const USER_EMAIL = "'.$_REQUEST['email'].'";'."\n";
			} elseif (trim($line) == 'const USER_PWD = "123456";') {
				$line = '    const USER_PWD = "'.$_REQUEST['pwd'].'";'."\n";
			}

			fwrite($file_bk, $line);
		}
		fclose($file);
	}

	fclose($file_bk);

	unlink($_SERVER["DOCUMENT_ROOT"] . "/packages/august/database/seeders/UserSeeder.php");
	rename($_SERVER["DOCUMENT_ROOT"] . "/packages/august/database/seeders/UserSeeder_bk.php", $_SERVER["DOCUMENT_ROOT"] . "/packages/august/database/seeders/UserSeeder.php");

	// AExtendblockUserRoleRelationSeeder
	$str = "";
	$file = fopen($_SERVER["DOCUMENT_ROOT"] . "/packages/august/database/seeders/AExtendblockUserRoleRelationSeeder.php", "r");
	$file_bk = fopen($_SERVER["DOCUMENT_ROOT"] . "/packages/august/database/seeders/AExtendblockUserRoleRelationSeeder_bk.php", "w");
	if ($file) {
		while(!feof($file)) {
			$line = fgets($file);

			if (trim($line) == '$user = AExtendblockUsers::where("email", "august-admin@dcsoft.com")->first();') {
				$line = '       $user = AExtendblockUsers::where("email", "'.$_REQUEST['email'].'")->first();'."\n";
			}

			fwrite($file_bk, $line);
		}
		fclose($file);
	}

	fclose($file_bk);

	unlink($_SERVER["DOCUMENT_ROOT"] . "/packages/august/database/seeders/AExtendblockUserRoleRelationSeeder.php");
	rename($_SERVER["DOCUMENT_ROOT"] . "/packages/august/database/seeders/AExtendblockUserRoleRelationSeeder_bk.php", $_SERVER["DOCUMENT_ROOT"] . "/packages/august/database/seeders/AExtendblockUserRoleRelationSeeder.php");

	// symlink august
	$link = $_SERVER["DOCUMENT_ROOT"] . "/public/assets-august";
    $target = $_SERVER["DOCUMENT_ROOT"] . "/packages/august/resources/assets-august";

    if (!is_link($link)) {
        symlink($target, $link);
    }

    // symlink storage
    $link = $_SERVER["DOCUMENT_ROOT"] . "/public/storage";
    $target = $_SERVER["DOCUMENT_ROOT"] . "/storage/app/public";

    if (!is_link($link)) {
        symlink($target, $link);
    }

    // symlink packages
    $filename = $_SERVER["DOCUMENT_ROOT"] . "/vendor/packages";

	if (!file_exists($filename)) {
	    mkdir($filename);
	}

    $link = $_SERVER["DOCUMENT_ROOT"] . "/vendor/packages/august";
    $target = $_SERVER["DOCUMENT_ROOT"] . "/packages/august";

    if (!is_link($link)) {
        symlink($target, $link);
    }

	$step = 3;
}
?>

<body style="margin: 0;">
	<style>
		.step {
			border: 1px solid #ddd; color: #ffffff; background-color: #ddd; padding: 5px 10px; border-radius: 100%; font-size: 20px; position: relative;
		}

		.step.active {
			border: 1px solid #ff2d20; color: #ffffff; background-color: #ff2d20; padding: 5px 10px; border-radius: 100%; font-size: 20px; position: relative;
		}

		.container,
		form {
			display: flex; flex-direction: column; gap: 10px; max-width: 600px; margin: 50px auto 0;
		}

		input[type="submit"] {
			min-height: 30px; width: fit-content; margin: 0 auto;
		}
	</style>
	<img id="background" src="https://laravel.com/assets/img/welcome/background.svg" style="position: absolute; width: 50%; top: 0; left: 0;">
	<div style="position: relative;">
		<div style="text-align: center;">
			<h1 style="color: #ff2d20">Install August CMS</h1>
		</div>
		<div style="display: flex; justify-content: space-between; position: relative; max-width: 600px; margin: 0 auto;">
			<hr style="position: absolute; top: 50%; width: 100%; left: 0; margin: 0; width: calc(100% - 2px);">
			<?php
			for ($i=1; $i <= 3; $i++) {
				if ($i == $step) {
					$active = "active";
				} else {
					$active = "";
				}
				?>
				<span class="step <?php echo $active;?>"><?php echo $i?></span>
				<?php
			}
			?>
		</div>
		<?php
		if ($step == 1) {
			?>
			<form action="" method="post">
				<label>Database</label>
				<input type="" name="database" style="min-height: 30px;" required>
				<label>User</label>
				<input type="" name="user" style="min-height: 30px;" required>
				<label>Password</label>
				<input type="" name="pwd" style="min-height: 30px;" required>
				<input type="submit" name="submit" value="submit">
				<input type="hidden" name="step" value="1">
			</form>
			<?php
		} elseif ($step == 2) {
			?>
			<form action="" method="post">
				<label>Account</label>
				<input type="email" name="email" style="min-height: 30px;" required>
				<label>Password</label>
				<input type="" name="pwd" style="min-height: 30px;" required>
				<input type="submit" name="submit" value="submit">
				<input type="hidden" name="step" value="2">
			</form>
			<?php
		} else {
			?>
			<div class="container">
				<div>Now, You need to open the command prompt and execute:</div>
				<div>1/ composer update</div>
				<div>2/ php artisan migrate --path="packages/august/database/migrations/"</div>
				<div style="color: red;">*/ If you use MAMP on MAC, please go to file /config/database.php and change 'unix_socket' => env('DB_SOCKET', '') to 'unix_socket' => env('DB_SOCKET', '/Applications/MAMP/tmp/mysql/mysql.sock') of mysql</div>
				<div>3/ Go to <a href="/august/login">/august/login</a></div>
			</div>
			<?php
		}
		?>
	</div>
</body>
</html>