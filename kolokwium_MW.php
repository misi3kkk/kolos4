<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Kalkulator BMI </title>
</head>
<body>
Kalkulator BMI
<form method="POST" action="">
	Płeć:
	<input type="radio" name="plec" value="m"> Mężczyzna
	<input type="radio" name="plec" value="k"> Kobieta
	<br><br>
	Wiek:
	<input type="number" name="wiek" min="18" max="99"> (18-99)
	<br><br>
	Waga:
	<input type="number" name="waga"> kg
	<br><br>
	Wzrost:
	<input type="number" name="wzrost"> cm
	<br><br>
	Poziom aktywności fizycznej:
	<br><br>
	<select name="aktywnosc">
		<option name="ak1" value="ak1">Brak aktywności</option>
		<option name="ak2" value="ak2">Bardzo lekka aktywność (1 dzień w tygodniu)</option>
		<option name="ak3" value="ak3">Lekka aktywność (2-3 dni w tygodniu)</option>
		<option name="ak4" value="ak4">Średnia aktywność (4-5 dni w tygodniu)</option>
		<option name="ak5" value="ak5">Duża aktywność (codziennie)</option>
		<option name="ak6" value="ak6">Bardzo duża aktywność</option>
</select>
<br><br>
<input type="submit" value="Zapisz i Oblicz">
</form>
</body>
</html>

<?php
	error_reporting(0);
	$ra="";
	$cpm=0;
	$pal=0;
	$plec=$_POST['plec'];
	$wiek=$_POST['wiek'];
	$waga=$_POST['waga'];
	$wzrost=$_POST['wzrost'];
	$aktywnosc=$_POST['aktywnosc'];

	function calculateBMI($waga, $wzrost)
	{
		return round($waga / (($wzrost / 100) **2), 2);
	}
	function calculatePPM($waga, $wzrost, $wiek)
	{
		return round(10*$waga)+(6.25*$wzrost)-(5*$wiek)+5;
	}
	function calculateCPM ($ppm, $pal)
	{
		return round($ppm*$pal);
	}

	$bmi=calculateBMI($waga, $wzrost);
	$ppm=calculatePPM($waga, $wzrost, $wiek);
	echo "<br> Twoje BMI wynosi: ".$bmi;
	echo "<br> Twoje PPM wynosi: ".$ppm;

	if($plec =="m")
	{
		if($aktywnosc == "ak1")
		{
			$pal = 1.2;
			$ra = "Brak aktywności";
		}
		else if($aktywnosc == "ak2")
		{
			$pal = 1.3;
			$ra = "Bardzo lekka aktywność (1 dzień w tygodniu)";
		}
		else if ($aktywnosc == "ak3")
		{
			$pal = 1.6;
			$ra = "Lekka aktywność (2-3 dni w tygodniu)";
		}
		else if($aktywnosc == "ak4")
		{
			$pal = 1.7;
			$ra = "Średnia aktywność (4-5 dni w tygodniu";
		}
		else if ($aktywnosc == "ak5")
		{
			$pal = 2.1;
			$ra = "Duża aktywność (codziennie)";
		}
		else if($aktywnosc == "ak6")
		{
			$pal = 2.4;
			$ra = "Bardzo duża aktywność";
		}
	}
	if ($plec == "k")
	{
		if($aktywnosc == "ak1")
		{
			$pal = 1.2;
			$ra = "Brak aktywności";
		}
		else if($aktywnosc == "ak2")
		{
			$pal = 1.3;
			$ra = "Bardzo lekka aktywność (1 dzień w tygodniu)";
		}
		else if ($aktywnosc == "ak3")
		{
			$pal = 1.5;
			$ra = "Lekka aktywność (2-3 dni w tygodniu)";
		}
		else if($aktywnosc == "ak4")
		{
			$pal = 1.6;
			$ra = "Średnia aktywność (4-5 dni w tygodniu";
		}
		else if ($aktywnosc == "ak5")
		{
			$pal = 1.9;
			$ra = "Duża aktywność (codziennie)";
		}
		else if($aktywnosc == "ak6")
		{
			$pal = 2.2;
			$ra = "Bardzo duża aktywność";
		}
	}

	$cpm = calculateCPM($ppm, $pal);
	echo "<br> Twoje CPM wynosi: ".$cpm;
	$polaczenie = new mysqli ('localhost', 'root', '', 'kalkulator_bmi');
	$query = "INSERT INTO raport values ('$wiek', '$waga', '$wzrost', '$plec', '$bmi', '$ra')";
	$result = mysqli_query($polaczenie, $query);

	if($bmi<16)
	{
		echo "<br> Twoje BMI wskazuje na wygłodzenie";
	}
	else if($bmi>=16 && $bmi<=16.99)
	{
		echo "<br> Twoje BMI wskazuje na wychudzenie";
	}
	else if($bmi>=17 && $bmi<=24.99)
	{
		echo "<br> Twoje BMI wskazuje na wagę prawidłową";
	}
	else if ($bmi>=25 && $bmi<=29.99)
	{
		echo "<br> Twoje BMI wskazuje na nadwagę";
	}
	else if($bmi>=30 && $bmi<=34.99)
	{
		echo "<br> Twoje BMI wskazuje na I stopień otyłości";
	}
	else if($bmi>=35 && $bmi<=39.99)
	{
		echo "<br> Twoje BMI wskazuje na II stopień otyłości";
	}
	else if($bmi>40)
	{
		echo "<br> Twoje BMI wskazuje na otyłość skrajną";
	}
