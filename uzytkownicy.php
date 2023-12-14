<!DOCTYPE html>

<html lang="pl">

	<head>
		<meta charset="utf-8"/>
		<title>Portal społecznościowy</title>
		<link rel="stylesheet" type="text/css" href="styl5.css"/>
	</head>

	<body>
	
		<header id ="lewy">
			<h2>Nasze osiedle</h2>
		</header>
		
		<header id ="prawy">
			<?php
				$dbhost="localhost";
				$dbuser="root";
				$dbpass="";
				$dbname="portal";
				
				$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
				
				$zapytanie = "SELECT COUNT(*) FROM dane";
				
				$result = mysqli_query($db, $zapytanie);
				
				while($row = mysqli_fetch_array($result)){
					echo "<h5>Liczba użytkowników portalu: " . $row['COUNT(*)'] . "</h5>";
				}
				mysqli_close($db);
			?>
		</header>
		
		
		<section id="left">
			<h3>Logowanie</h3>
			<form action="uzytkownicy.php" method="post">
				login<br><input type="text" name="login" /><br>
				hasło<br><input type="password" name="haslo" /><br>
				<input type="submit" value="Zaloguj" />
			</form>
		</section>
		
		<section id="right">
			<h3>Wizytówka</h3>
			<?php
				$dbhost="localhost";
				$dbuser="root";
				$dbpass="";
				$dbname="portal";
				
				$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
				
				if (!empty($_POST['login']) && !empty($_POST['haslo'])) {

                $qrrM = "SELECT haslo FROM uzytkownicy WHERE login=\"{$_POST['login']}\"";
                $res = mysqli_query($db, $qrrM);

                $login_d_exist = "Login nieprawidłowy";
                $passwd_incr = "Hasło nieprawidłowe!";

                if (mysqli_num_rows($res) == 0) {
                    echo "$login_d_exist";
                } else {
                    $passwd = $_POST['haslo'];
                    $passwd = sha1($passwd);
                    $login = $_POST['login'];

                    if (mysqli_num_rows($res) == 1) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            if ($passwd == $row['haslo']) {

                                $qrrN = "SELECT uzytkownicy.login, dane.rok_urodz, dane.przyjaciol, dane.hobby, dane.zdjecie FROM uzytkownicy JOIN dane on dane.id=uzytkownicy.id WHERE uzytkownicy.login=\"{$login}\"";
                                $resN = mysqli_query($db, $qrrN);

                                while ($row = mysqli_fetch_assoc($resN)) {
                                    $wiek = 2022 - $row['rok_urodz'];
                                    echo "<div>";
                                    echo "<img src=\"{$row['zdjecie']}\" alt='osoba'>";
                                    echo "<h4>{$row['login']} ({$wiek})</h4>";
                                    echo "<p>hobby: {$row['hobby']}</p>";
                                    echo "<h1><img src='icon-on.png'>{$row['przyjaciol']}</h1>";
                                    echo '<button><a href="dane.html">Więcej informacji</a></button>';
                                    echo "</div>";
                                }
                            } else
                                echo "$passwd_incr";
						}
                    }
                }
            }
				mysqli_close($db);

			?>
		</section>
		
		
		<footer>
			<p>Stronę wykonał: 00000000</p>
		</footer>
	</body>

</html>